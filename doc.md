FORMAT: 1A

# Service

## Authentication

使用OAuth2.0的client credentials方式进行认证。

请求token发放接口传入client_id, client_secret 获得 access_token

后续需要认证的请求将access_token放到header中进行认证：

**HTTP header:**

```
Authorization: Bearer {{access_token}}
```


# Group token

获取access_token 以供后续请求认证

## 请求token [/oauth/token]

### 获取access_token [POST /oauth/token]

::: warning
grant_type 需传入值：`client_credentials`
:::

+ Request
    + Attributes
        + client_id: 2 (number, required)
        + client_secret: `1fb29dd` (string, required)
        + grant_type: `client credentials` (string, required)
            + default: `client_credentials`

+ Response 200
    + Attributes (Token)

# Group Ads
多媒体广告

## 多媒体列表 [/api/ads]

### 获取多媒体列表 [GET /api/ads{?page,perPage}]

+ Parameters
    + page: `1` (number, optional) - 当前第几页
    + perPage: `5` (number, optional) - 每页显示条数
        + Default: `5`
        
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
                
+ Response 200
    + Attributes
        + data (Ads)
        + meta
            + pagination (Pagination) 
            
### 新增多媒体 [POST /api/ads]

+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
                 
    + Attributes
        + duration: 10 (number, optional) 
        + s_time: `2017-10-01 00:00:59` (string, optional)
        + e_time: `2017-10-03 00:00:59` (string, optional)
    
+ Response 200
    + Attributes
        + data (Ad)
     
## 多媒体 [/api/ads/{id}]

### 获取多媒体详情 [GET /api/ads/{id}]

+ Parameters
    + id: `1` (number, required) - 多媒体ID
        
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}        
    
+ Response 200
    + Attributes
        + data (Ad)


### 更新多媒体 [PUT /api/ads/{id}]
更新某个多媒体

+ Parameters
    + id: `1` (number, required) - 多媒体ID
    
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
                      
    + Attributes
        + ad
            + duration: 10 (number, optional) 
    
+ Response 200
    + Attributes
        + data (Ad)
        
### 删除多媒体 [DELETE /api/ads/{id}]
删除某个多媒体

+ Parameters
    + id: `1` (number, required) - 多媒体ID
    
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
+ Response 204


# Group FaceSet

## 人脸库 [/api/faceset]

### 新增人脸库 [POST /api/faceset]

+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
              
    + Attributes
        + id: 1 (number, optional) - 人脸库分组ID
        + display_name: baidu (string, required) - 人脸库显示名称
        
+ Response 200
        
### 人脸库详情 [GET /api/faceset/{id}]

+ Parameters
    + id: `1` (number, required) - 人脸库分组ID
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
+ Response 200
    
### 删除人脸库 [DELETE /api/faceset/{id}]

+ Parameters
    + id: `1` (number, required) - 人脸库分组ID
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
+ Response 204
    
## 人脸数据 [/api/faceset/{id}/face/{face_token}/]

### 添加人脸数据 [POST /api/faceset/{id}/face]

+ Parameters
    + id: `1` (number, required) - 人脸库分组ID
           
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
    + Attributes
        + user_id: 2 (number, required)
        + file: `一个文件` (string, optional) - 人脸图片文件
        + url: `http://host/file.jpg` (string, optional) - 人脸图片url
        
+ Response 200

### 抹除人脸数据 [DELETE /api/faceset/{id}/face/{face_token}]

+ Parameters
    + id: `1` (number, required) - 人脸库分组ID
    + face_token: abc (string, required) - face token
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
             
    
+ Response 204

# Group SignIn

## 签到 [/api/signin/{id}]

## 签到列表 [GET /api/signin]
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
        
+ Response 200 
    + Attributes
        + data (SignInList)
        + meta
            + pagination (Pagination)
            
## 签到详情 [GET /api/signin/{id}]

+ Parameters
    + id: `2` (number, required) - 签到ID
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
+ Response 200 
    + Attributes
        + data (SignIn)
        
## 写入签到数据 [POST /api/signin]
  
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
    + Attributes
        + sign_in_type: 1 (number, required) - 签到类型
        + file: `一个文件` (string, optional) - 图片文件
        + url: `http://host/file.jpg` (string, optional) - 图片url

+ Response 200
    + Attributes
        + data (SignIn)
        
### 更新签到数据 [PUT /api/signin/{id}]

+ Parameters
    + id: `2` (number, required) - 签到ID
        
+ Request
    + Headers
        
            Authorization: Bearer {{access_token}}
       
    + Attributes
        + address (string, optional)
        + position (string, optional)
        + remark (string, optional)
        
+ Response 204

# Data Structures

## Ad
  + id: 1 (number) - 多媒体id
  + duration: 10 (number) - 播放时长，单位：秒
  + url (string) - 多媒体路径
  
## Ads (array)
  + (Ad)
  
## FaceSet

## Face

## SignIn
  + id: 1 (number)
  + user_id: 3 (number)
  + sign_in_time: `2017-01-01 12:00:09` (string)
  + address: `公司` (string)
  + position: `门口` (string)
  + remark: `备注` (string)

## SignInList (array)
  + (SignIn)

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
    
## Token
  + token_type: Bearer (string)
  + expire_in: 31536000 (number)
  + access_token: `eyJ0e.eyJhdWQ.TjOOjx6kdPxc` (string)