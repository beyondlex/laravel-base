<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Department;
use App\Models\Level;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Jenssegers\Mongodb\Query\Builder;

class Migrate extends Command
{
	use ValidatesAttributes;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate {name} {--from=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Notice: 树型数据结构的表 对应的类中的NodeTrait 要注释

		$t = time();
		$this->info(date('Y-m-d H:i:s'));

		$base = [
			'company', 'level',
		];
		$sub = [
			'staff', 'department', 'role',
		];
		$name = $this->argument('name');
		if (substr($name, 0, 2) == 'un') {
			$this->{$name}();
		} else {
			if (in_array($name, $base)) {

			}
			elseif (in_array($name, $sub)) {
				if (!$this->option('from')) {
					$this->error('start index of database can not be null');
					exit;
				}
				if (!$this->option('to')) {
					$this->error('end index of database can not be null');
					exit;
				}
			} else {
				$this->error('invalid name');
				exit;
			}

			$this->{$name}($this->option('from'), $this->option('to'));
		}


		$this->info('using seconds: '. (time()-$t));
    }

	function company() {
		$this->companyCreate();
		$this->companyUpdate();
	}

	function level() {
		$this->levelCreate();
		$this->levelUpdate();
	}

	function department($from, $to) {
    	$this->departmentCreate($from, $to);
    	$this->departmentUpdate();
	}

	function role($from, $to) {
    	$this->roleCreate($from, $to);
    	$this->roleUpdate();
	}

	function staff($from, $to) {
    	$this->staffCreate($from, $to);
    	$this->staffUpdate();
	}


	protected function unAll() {
    	$this->unStaff();
    	$this->unCompany();
    	$this->unDepartment();
    	$this->unRole();
    	$this->unLevel();
	}
	protected function unDepartment() {
		DB::statement('truncate table departments');
		$conn = $this->getMdbConn('department');
		$conn->truncate();
	}

	protected function unCompany() {
		DB::statement('truncate table companies');
		$conn = $this->getMdbConn('company');
		$conn->truncate();
	}

	protected function unLevel() {
		DB::statement('truncate table levels');
		$conn = $this->getMdbConn('level');
		$conn->truncate();
	}

	protected function unRole() {
		DB::statement('truncate table roles');
		$conn = $this->getMdbConn('role');
		$conn->truncate();
	}

	protected function unStaff() {
		DB::statement('truncate table staff');
		DB::statement('truncate table profiles');
		$conn = $this->getMdbConn('staff');
		$conn->truncate();
	}


	protected function staffCreate($from, $to) {
		$mdb = $this->getMdbConn('staff');

		$conn = $this->getBaseConn();

		for ($i=$from; $i<=$to; $i++) {
			$companyIds = $this->getCompanyIdByDbIndex($i);
			if (!$companyIds) continue;
			//foreach company
			foreach ($companyIds as $companyId) {
				$dbName = "curato{$i}";
				$tableName = "{$companyId}_user";
				try {
					$users = $conn->select("select * from {$dbName}.{$tableName} where deleted = 0 ");
					if (!$users) continue;
					foreach ($users as $user) {
						$m = new Staff();
						$m->department_id = $user->department_id;
						$m->role_id = $user->role_id;
						if (strpos($user->phone, '&') !== false) {
							$user->phone = substr($user->phone, 0, 12);
						}
						$m->phone = $user->phone;

						if ($user->email) $m->email = $user->email;

						$m->password = $user->passw;
						$m->confirm_password = $user->confirm_passw;
						$m->status = $user->status;
						if ($this->validateDate(null, $user->last_login)) {
							$m->last_login = $user->last_login;
						}
						if ($this->validateDate(null, $user->reg_time)) {
							$m->created_at = $user->reg_time;
						}
						if ($this->validateDate(null, $user->update_time)) {
							$m->updated_at = $user->update_time;
						}


						$m->send_sms = $user->send_message;
						$m->face_tokens = $user->face_tokens;
						$m->face_status = $user->face_status;

						$m->company_id = $companyId;

						if ($m->save()) {
							$mdb->insert([
								'old'=>'company.'.$companyId.'.staff.'.$user->id,
								'new'=>$m->id,
							]);

							$m2 = new Profile();
							$m2->name = $user->name;
							$m2->gender = $user->sex;
							$m2->telephone = $user->telephone;
							$m2->telephone_ext = $user->telephone_ext;
							$m2->address = $user->address;
							$m2->remark = $user->note;
							$m2->avatar = $user->img_url;
							$m2->visible = $user->range;
							$m2->staff_id = $m->id;
							$m2->save();
						}

					}
				} catch (\Exception $e) {
					Log::error('insert staff error', [$e->getMessage(), 'index'=>$i, 'cid'=>$companyId]);
				}
			}

		}
	}

	protected function staffUpdate() {
    	//update department_id, role_id, company_id
    	Staff::chunk(100, function($staff) {
    		/** @var Staff $s */
			foreach ($staff as $s) {

				$oldCompanyId = $s->company_id;
				$oldDepartmentId = $s->department_id;
				$oldRoleId = $s->role_id;

				$key = "company.{$oldCompanyId}";
				$mdb  = $this->getMdbConn('company');
				$map = $mdb->where('old', '=', $key)->first();
				if ($map['new']) $s->company_id = $map['new'];

				$key = "company.{$oldCompanyId}.department.{$oldDepartmentId}";
				$mdb  = $this->getMdbConn('department');
				$map = $mdb->where('old', '=', $key)->first();
				if ($map['new']) $s->department_id = $map['new'];

				$key = "company.{$oldCompanyId}.role.{$oldRoleId}";
				$mdb  = $this->getMdbConn('role');
				$map = $mdb->where('old', '=', $key)->first();
				if ($map['new']) $s->role_id = $map['new'];

				$s->save();
			}
		});
	}


	protected function departmentCreate($from, $to) {
    	$mdb = $this->getMdbConn('department');

    	$conn = $this->getBaseConn();


    	for ($i=$from; $i<=$to; $i++) {
    		//foreach database:
//			config([$this->getSubDbConfigKey()=>'curato'.$i]);
//			$conn = DB::connection('curato_n');


			$companyIds = $this->getCompanyIdByDbIndex($i);
			if (!$companyIds) continue;
			//foreach company
			foreach ($companyIds as $companyId) {
//				$t1 = time();
				$dbName = "curato{$i}";
				$tableName = "{$companyId}_department";
				try {
					$departments = $conn->select("select * from {$dbName}.{$tableName} ");
					if (!$departments) continue;
					foreach ($departments as $department) {
						$m = new Department();
						$m->name = $department->department_name;

						if ($department->pid) $m->parent_id = $department->pid;

						$m->created_at = $this->validateDate(null, $department->create_time)
							? $department->create_time
							: date('Y-m-d H:i:s');

						if ($department->deleted) {
							continue;//已删除的不导入
//							$m->deleted_at = date('Y-m-d H:i:s');
						}

						$m->company_id = $companyId;

						if ($m->save()) {
							$mdb->insert([
								'old'=>'company.'.$companyId.'.department.'.$department->id,
								'new'=>$m->id,
							]);
						}

					}
				} catch (\Exception $e) {
					Log::error('insert department error', [$e->getMessage(), $i]);
				}

//				print_r('department done in company.'.$companyId);
//				print_r('using secs: '. (time()-$t1));
			}

		}
	}

	protected function departmentUpdate() {

    	//update parent_id and company_id and lft and rgt

		Department::chunk(100, function($departments) {
			/** @var Department[] $departments */
			/** @var Builder $mdb */
			foreach ($departments as $department) {
				$key = "company.{$department->company_id}.department.{$department->parent_id}";
				$mdb = $this->getMdbConn('department');
				$departMap = $mdb->where('old', '=', $key)->first();

				if ($departMap['new']) $department->parent_id = $departMap['new'];

				$key = "company.{$department->company_id}";
				$mdb  = $this->getMdbConn('company');
				$companyMap = $mdb->where('old', '=', $key)->first();

				if ($companyMap['new']) $department->company_id = $companyMap['new'];

				$department->save();
			}
		});

		Department::fixTree();//需要确保Department use trait: NodeTrait

	}

	protected function companyUpdate() {
		//update pid
    	Company::whereNotNull('pid')->chunk(100, function ($companies) {
    		/** @var Company $company */
			foreach ($companies as $company) {
    			$key = "company.{$company->pid}";
    			$mdb = $this->getMdbConn('company');
    			$companyMap = $mdb->where('old', '=', $key)->first();

    			if ($companyMap['new']) {
    				$company->pid = $companyMap['new'];
				} else {
    				continue;
				}
    			$company->save();
			}
		});
	}

	protected function companyCreate() {
		$companies = $this->getBaseConn()->select('select * from t_company');
		$oldPrimaryKeyCompany = 'company.';

		$mdb = $this->getMdbConn('company');

		$companyTransform = [
			'company_id'=>'code',
			'company_name'=>'name',
			'company_phone'=>'phone',
			'company_address'=>'address',
			'company_logo'=>'logo',
			'area_code'=>'area_code',
			'province'=>'province',
			'city'=>'city',
			'district'=>'district',
			'contact_name'=>'contact_name',
			'contact_phone'=>'contact_phone',
			'contact_sex'=>'contact_gender',
			'contact_role'=>'contact_role',
			'contact_email'=>'contact_email',
			'company_status'=>'status',
			'company_scale'=>'scale',
			'company_industry'=>'industry',
			'reg_time'=>'created_at',
			'deleted'=>'deleted_at',
			'reg_from'=>'reg_from',
			'reg_by'=>'reg_by',
			'channel'=>'channel',
			'sales_email'=>'sales_email',
		];

		foreach ($companies as $company) {
			$m = new Company();

			foreach ($companyTransform as $old=>$new) {
				if ($new == 'deleted_at') {
					if ($company->{$old}) {
						$m->{$new} = date('Y-m-d H:i:s');
						continue;
					} else {
						continue;
					}
				}

				if ($new == 'code' and !$company->{$old}) {
					$company->{$old} = substr(uniqid(), 3, 16);
				}

				$m->{$new} = $company->{$old};
			}

			try {
				if ($m->save()) {
					$mdb->insert([
						'old'=>$oldPrimaryKeyCompany.$company->id,
						'new'=>$m->id,
					]);
				}
			} catch (\Exception $e) {
				Log::error('insert company error', [$e->getMessage()]);
			}

		}
	}

	protected function levelCreate() {
		$levels = $this->getBaseConn()->select('select * from t_level where deleted=0');

		$mdb = $this->getMdbConn('level');

		foreach ($levels as $level) {
			$m = new Level();

			$m->company_id = $level->company_id;
			if ($level->pid)
				$m->parent_id = $level->pid;
			$m->name = $level->level_name;
			$m->readonly = (int)(!$level->is_deleted);
			if ($level->deleted) {
				$m->deleted_at = date('Y-m-d H:i:s');
			}
			if ($level->sort) $m->sort = $level->sort;

			try {
				if ($m->save()) {
					$mdb->insert([
						'old'=>'level.'.$level->id,
						'new'=>$m->id,
					]);
				}
			} catch (\Exception $e) {
				Log::error('insert level error', [$e->getMessage()]);
			}


		}
	}

	protected function levelUpdate() {
    	//update parent_id , company_id
		Level::chunk(100, function($levels) {

			/** @var Level $level */
			foreach ($levels as $level) {
				$key = "level.{$level->parent_id}";
				$mdb = $this->getMdbConn('level');
				$map = $mdb->where('old', '=', $key)->first();
				if ($map['new']) $level->parent_id = $map['new'];

				$key = "company.{$level->company_id}";
				$mdb  = $this->getMdbConn('company');
				$map = $mdb->where('old', '=', $key)->first();

				if ($map['new']) $level->company_id = $map['new'];

				$level->save();
			}
		});
	}

	protected function roleCreate($from, $to) {

		$mdb = $this->getMdbConn('role');
		$conn = $this->getBaseConn();

		for ($i=$from; $i<=$to; $i++) {
			$companyIds = $this->getCompanyIdByDbIndex($i);
			if (!$companyIds) continue;
			//foreach company
			foreach ($companyIds as $companyId) {
				$dbName = "curato{$i}";
				$tableName = "{$companyId}_role";
				try {
					$olds = $conn->select("select * from {$dbName}.{$tableName} ");
					if (!$olds) continue;
					foreach ($olds as $old) {

						if (!$old->status) {
							continue;//已删除的不导入
						}

						$m = new Role();
						$m->name = $old->ch_value;
						if (!$old->status) $m->deleted_at = date('Y-m-d H:i:s');


						$m->created_at = $this->validateDate(null, $old->create_time)
							? $old->create_time
							: date('Y-m-d H:i:s');

						$m->company_id = $companyId;

						$m->level_id = $old->level_id;

						if ($m->save()) {
							$mdb->insert([
								'old'=>'company.'.$companyId.'.role.'.$old->id,
								'new'=>$m->id,
							]);
						}

					}
				} catch (\Exception $e) {
					Log::error('insert role error', [$e->getMessage(), $i]);
				}
			}
		}
	}

	protected function roleUpdate() {

    	Role::chunk(100, function($roles) {
    		/** @var Role $role */

			foreach ($roles as $role) {
				$key = "company.{$role->company_id}";
				$mdb  = $this->getMdbConn('company');
				$companyMap = $mdb->where('old', '=', $key)->first();

				if ($companyMap['new']) $role->company_id = $companyMap['new'];

				$key = "level.{$role->level_id}";
				$mdb  = $this->getMdbConn('level');
				$map = $mdb->where('old', '=', $key)->first();

				if ($map['new']) $role->level_id = $map['new'];

				$role->save();
			}
		});
	}



	private function getBaseConn() {
		static $conn;
		if ($conn) return $conn;
		return $conn = DB::connection('curato_base');
	}

	private function getCompanyIdByDbIndex($index=null) {
		if ($index) {
			$ids = $this->getBaseConn()->select('select company_id from t_database where dbname = :index', ['index'=>$index]);
		} else {
			$ids = $this->getBaseConn()->select('select company_id from t_database');
		}

		$return = [];
		foreach ($ids as $id) {
			$return[] = $id->company_id;
		}
		return $return;
	}

	private function getSubDbConfigKey() {
		return 'database.connections.curato_n.database';
	}

	private function getMdbConn($tableName) {
		$mongodb = \Illuminate\Support\Facades\DB::connection('mongodb');
		$mongodb->enableQueryLog();
		$this->conn = $mongodb;
		$mdb = $mongodb->collection('map.'.$tableName);
		return $mdb;
	}
}
