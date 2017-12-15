FORMAT: 1A

# Service

## Authentication

请求签名算法：

请求参数中去掉sign参数后，对参数名按升序排序，去掉空值的键值对后按key1=value1;key2=value2...的形式拼接成字符串，
然后将client_secret拼接到字符串的前面并进行sha1加密得到sign

:::note 

如：

请求参数为name=lex&age=18&gender=M&client_id=2&sign=5423b7a64dd4e41841fb41a0afbe4469c056a1b8

去掉sign参数，对参数名按升序排序：age=18&client_id=2&gender=M&name=lex

拼接后：age=18;client_id=2;gender=M;name=lex;

若client_secret=hello

则sha1加密后：
```php
sign = sha1('helloage=18;client_id=2;gender=M;name=lex;')
```

output:
```bash
5423b7a64dd4e41841fb41a0afbe4469c056a1b8
```

:::




# Group Logs
日志相关操作

### 获取日志列表 [GET /api/logs{?search,searchJoin}]

+ Parameters
    + search: `channel:channelName;level:100` (string, optional) - Search by fields
    + searchJoin: `and` (string, optional) - Join way of field
      + Default: `or`

+ Response 200 
    + Attributes
        + data (LogList)
        + meta
            + pagination (Pagination)



# Data Structures

## Log 
  + channel: laravel (string) - Log channel
  + level: 100 (string) - 100:debug, 250:notice
  + message: hello (string) - Log message
  + context: some thing (string) - Log context
  
## LogList (array)
  + (Log)

## Pagination
  + total: 23 (number)
  + count: 3 (number)
  + per_page: 5 (number)
  + current_page: 2 (number)
  + total_pages: 9 (number)
  + links
    + prev: /api/logs?perPage=2&page=1 (string)
    + next: /api/logs?perPage=2&page=3 (string)