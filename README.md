## Configuration
First step is clone this repository. Then, run command below
```
composer update
```
Next, generate key
```
php artisan key:generate
```
Next, setup environment .env like database, redis connection, etc. Especialy QUEUE_CONNECTION change sync to redis
```
QUEUE_CONNECTION=redis
```
Next, run command below
```
php artisan optimize
```
Next, migrate the migrations
```
php artisan migrate
```
Next, install laravel passport
```
php artisan passport:install
```
Next, open public access storage link to open image uploaded
```
php artisan storage:link
```
And then, run the service
```
php artisan serve
```

Open new terminal and run command below to run queue
```
php artisan queue:work
```

## Services
| Name  | Method | Route |
| ------------- | ------------- | ------------- |
| user.register | POST | {{baseUrl}}/api/register  |
| user.login | POST | {{baseUrl}}/api/login  |
| user.detail | POST | {{baseUrl}}/api/detail  |
| news.create | POST | {{baseUrl}}/api/news  |
| news.detail | GET | {{baseUrl}}/api/news/{{id}}  |
| news.update | POST | {{baseUrl}}/api/news/{{id}}  |
| news.delete | DELETE | {{baseUrl}}/api/news/{{id}}  |
| news.list | GET | {{baseUrl}}/api/news  |
| news.comment | POST | {{baseUrl}}/api/news/{{id}}/comment  |

### User Register
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/register' \
--form 'name="jds test"' \
--form 'email="jds.test1@mailinator.com"' \
--form 'password="112233"' \
--form 'confirm_password="112233"' \
--form 'is_admin="true"'
```
**Response Success :**
``` 
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZWJkZGViZWQzMWIwODY3NTM4MjZlMDU3ZjYzYmM2MmFmNWUwM2MyMjBmMzllMzI1MjM0NjkxMWZkNjhkNTc5ZTIzNzA5OTVkZjZhYzVlYTUiLCJpYXQiOjE2NzM3NzcyNDguMTA2MDM3LCJuYmYiOjE2NzM3NzcyNDguMTA2MDM5LCJleHAiOjE3MDUzMTMyNDguMDk4NzYxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.p8B9Yo7zC7noiAjqipArM8LAP9CeG6kAzHO7W4Gc2g_ay0JZ0xyI57wtXpFvORTGLXQg3D8jNjDeZ7FhK37OYhwJj81xTWmSOpPJiMlhToTrNSZS6b80uCRQWTb2buhnw-MIvPfryn8-7sBhlzNDBU322lGyQydclzuFLZ01v_z0biTAXJi5SqwiAqgMWqtlJfgbQ4Iu48h8S13-w_USTH2IWQMTPqHnhFdLsmjDsWQbKku831WoI8yFsSV-NWTwPA3DlRAILugowW5H2Hi9etFdNfUjgGcoxQ28wVZi5RSMsr9p8ktcpu0_eteqU5l8dOoykFn-bxI7BIM4ZLy3AYkoXnkk07j30JTHnUzBZ3tAgZkrf-sOCaqK_Pkg2L_BXf5bxgvnkOjdRa8LeNCfLRU0mhodcYMZ38DkS0hW_FVCjGD5n-e2s6DWaEBN1gzu0o2dvJ8jWwtJ3g6HJrGDsvFO1i4jXMD24-K1As1tTMvLenTM2Uhgfpvsdk6QcQv4qbsclKDcTdxLt6oND74h_2_vm8qWolU2ZJBdnZu6XxriKtMnCGaXjWGVSDG3CHoOScdw7LRgmNVfSnouYwESfvVmq-OlQRfWi0rJLW_7fbRUtzmf_48kXtyew_zVYxwuq2mvvxQFjYrA19dHhHv-TAD5ZMuLId3JzoiHn8RGhPM",
    "expires_in": 31536000,
    "data": {
        "name": "jds test",
        "email": "jds.test1@mailinator.com",
        "is_admin": 1,
        "updated_at": "2023-01-15T10:07:28.000000Z",
        "created_at": "2023-01-15T10:07:28.000000Z",
        "id": 1
    }
}
```

### User Login
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/login' \
--form 'email="jds.test1@mailinator.com"' \
--form 'password="112233"'
```
**Response Success :**
``` 
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2E3YTI1NmY0N2VlODJkYjE0ZDhjYjE0ZjdiOWJkYTI0MThkMWJlZjUzODFjZjkwMzUyZmQ1ZTZjYzQ4OTU0YmEwNzA2OTNhZDdiODExOWIiLCJpYXQiOjE2NzM3ODc5MTYuMjI1ODUxLCJuYmYiOjE2NzM3ODc5MTYuMjI1ODU1LCJleHAiOjE3MDUzMjM5MTYuMjE3NDQ2LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.A2vMxoVXpWjWFFUZKdAkMDod5Sln-eBoQsJtigvsDQH75k0DQ0Ia5OgeFOkrUoCmGUyzgHDs50fiLfiiqBM-4l50Sox7EuBLK_Zx-XiQEjltrQF_W_FGPKhCZlGVa-2jW9uYtm8xymhBH92xRKK3Ri5itEt66C1cUp_Y1M_L_kZ4K_ji-bIXd_sAAa17KLMRAthOOJxZkZjnlz0CWHfJTUhQsLiDo0WjBWHhNPTS3tyMB7ycJeEDIRRJhQrj_eDj-SGiYK9Y9xYCpfKyUCOP2-Ff3sZFPiivKMrO2CEpHZ85q90ks-DA-JRIr8puxMQgkttkCjODu92KIuKZeGVE2DUSJbs-0zWLx0ulwNbzhuoGTVHzBCWhfq-mBJRn9gkxueUAZsPzwRtJRwIvqq-ebIT4YXQfoAf44OkKxBb0IcK4UE_lBxJnkcnEyErcHFlcWZ6_PWfR9KLY7r1kW5KVFcPlfapakpmurl1DU78wS3swvHj1qwdXG771kS8ZIlHifZB8DR1nxRddbebKextW2sA6JGu9kwIGXxi4tKV8-ko_sbuoIkkt_CuixDDccA7X0RTS3lBFtZs0o3GbMBUgSdih7UodZtz42Lw29_LtH0y_85LUhnb_sOgFW5Qn8hqf1mXZl443SjIQeiwRnBifVbi95JkAtx7Mq9Ect1yFeMM",
    "expires_in": 31536000
}
```

### User Detail
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/detail'
```
**Response Success :**
``` 
{
    "data": {
        "id": 1,
        "name": "jds test",
        "email": "jds.test1@mailinator.com",
        "email_verified_at": null,
        "is_admin": 1,
        "created_at": "2023-01-15T10:07:28.000000Z",
        "updated_at": "2023-01-15T10:07:28.000000Z"
    }
}
```

### News Create
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/news' \
--form 'author="jds author"' \
--form 'title="jds title"' \
--form 'image=@"{{path_image}}"' \
--form 'content="jds content"'
```
**Response Success :**
``` 
{
    "message": "News successfully created",
    "data": {
        "author": "jds author",
        "title": "jds title",
        "content": "jds content",
        "image": "storage/news_images/Ic5zQCRNfSD2Un7EitOWjw9nd1xyZjFlU2Jjslap.png",
        "posted_by": 1,
        "updated_at": "2023-01-15T13:04:12.000000Z",
        "created_at": "2023-01-15T13:04:12.000000Z",
        "id": 7
    }
```

### News Detail
**Request :**
```
curl --location --request GET '{{baseUrl}}/api/news/{{id}}'
```
**Response Success :**
``` 
{
    "success": "success",
    "data": {
        "id": 5,
        "author": "jds author new",
        "title": "jds title new",
        "image": "{{baseUrl}}/storage/news_images/K4OHRssWdUgUtEJPQalln1Thvg0EFjmcSiDeyijW.png",
        "content": "jds content new",
        "posted_by": 1,
        "created_at": "2023-01-15T10:47:56.000000Z",
        "updated_at": "2023-01-15T10:50:03.000000Z",
        "deleted_at": null,
        "comments": [
            {
                "id": 1,
                "user_id": 1,
                "news_list_id": 5,
                "message": "jds comment",
                "created_at": "2023-01-15T10:56:47.000000Z",
                "updated_at": "2023-01-15T10:56:47.000000Z",
                "deleted_at": null
            },
            {
                "id": 2,
                "user_id": 1,
                "news_list_id": 5,
                "message": "jds comment",
                "created_at": "2023-01-15T10:56:47.000000Z",
                "updated_at": "2023-01-15T10:56:47.000000Z",
                "deleted_at": null
            }
        ]
    }
}
```

### News Update
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/news/{{id}}' \
--form 'author="jds author new"' \
--form 'title="jds title new"' \
--form 'image=@"/D:/Downloads/Screenshot 2023-01-15 115152.png"' \
--form 'content="jds content new"'
```
**Response Success :**
``` 
{
    "success": "News successfully updated",
    "data": {
        "id": 6,
        "author": "jds author new",
        "title": "jds title new",
        "image": "storage/news_images/wOkpDizwmFQMQ44gJRy2RsL8OSmmcwL4nnPP0F7f.png",
        "content": "jds content new",
        "posted_by": 1,
        "created_at": "2023-01-15T13:02:01.000000Z",
        "updated_at": "2023-01-15T13:02:07.000000Z",
        "deleted_at": null
    }
}
```

### News Delete
**Request :**
```
curl --location --request DELETE '{{baseUrl}}/api/news/{{id}}'
```
**Response Success :**
``` 
{
    "message": "News successfully deleted",
    "data": {
        "id": 7,
        "author": "jds author",
        "title": "jds title",
        "image": "storage/news_images/Ic5zQCRNfSD2Un7EitOWjw9nd1xyZjFlU2Jjslap.png",
        "content": "jds content",
        "posted_by": 1,
        "created_at": "2023-01-15T13:04:12.000000Z",
        "updated_at": "2023-01-15T13:06:58.000000Z",
        "deleted_at": "2023-01-15T13:06:58.000000Z"
    }
}
```

### News List
**Request :**
```
curl --location --request GET '{{baseUrl}}/api/news?page=1&per_page=2'
```
**Response Success :**
``` 
{
    "current_page": 1,
    "data": [
        {
            "id": 8,
            "author": "jds author",
            "title": "jds title",
            "image": "{{baseUrl}}/storage/news_images/N9A33pXXFPFAoR3P7RwEzXkf6xbufyTSaZ10bide.png",
            "content": "jds content",
            "posted_by": 1,
            "created_at": "2023-01-15T13:07:21.000000Z"
        },
        {
            "id": 5,
            "author": "jds author new",
            "title": "jds title new",
            "image": "{{baseUrl}}/storage/news_images/K4OHRssWdUgUtEJPQalln1Thvg0EFjmcSiDeyijW.png",
            "content": "jds content new",
            "posted_by": 1,
            "created_at": "2023-01-15T10:47:56.000000Z"
        }
    ],
    "first_page_url": "{{baseUrl}}/api/news?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "{{baseUrl}}/api/news?page=3",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "{{baseUrl}}/api/news?page=1",
            "label": "1",
            "active": true
        },
        {
            "url": "{{baseUrl}}/api/news?page=2",
            "label": "2",
            "active": false
        },
        {
            "url": "{{baseUrl}}/api/news?page=3",
            "label": "3",
            "active": false
        },
        {
            "url": "{{baseUrl}}/api/news?page=2",
            "label": "Next &raquo;",
            "active": false
        }
    ],
    "next_page_url": "{{baseUrl}}/api/news?page=2",
    "path": "{{baseUrl}}/api/news",
    "per_page": 2,
    "prev_page_url": null,
    "to": 2,
    "total": 5
}
```

### News Comment
**Request :**
```
curl --location --request POST '{{baseUrl}}/api/news/{{id}}/comment' \
--form 'message="jds comment"'
```
**Response Success :**
``` 
{
    "message": "Comment added successfully",
    "data": {
        "user_id": 1,
        "news_list_id": 8,
        "message": "jds comment"
    }
}
```
