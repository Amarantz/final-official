**Create User**
---
 Create user by passing in json body to and verify has email and username with a valid api key
 
* **URL**<br/>
`/user/create`<br/>

* **METHOD:**
    <br />`post`
    <br />`put`

* **URL Params**
    
    **Required:**
    ```
    CURL    -X post http://hostname/user/create
            -H "x-api-key=aa112341-12331211-5123123"
            -H "contentType:Application/json"
            {
                "Body":{
                    "Username":"someusername",
                    "email":"someEmail@email.com"
                },
            }   
       
    ```


* **Data Params**
     * **HEADER**
        * **CHAT-CLIENT-TOKEN** should verify with the database the token is valid.
            <br />`-H x-api-key=aa112341-12331211-5123123`
        * **contentType:**  This should how it will show the date weather its a Json file or if its HTML code to the screen
            **Allowed** content type "Application/json" 


* **Successful Response:**
    This should return the user id and uuid
    * **Code** 202<br/>
      **Content** 
      `{
            "userID":1123,
            "username":"someusername",
            "uuid":"somestringofnumbers",
            "email":"someEmail@email.com"
      }`
      
* **Error Response:**
    * **Code:**  417
      **Content:** `{"Error":"Missing Chat Client Token"}`
      
    * **Code:**  
      **Content:** `{}`

* **Example** 

