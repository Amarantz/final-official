**Update User**
---

* **URL**<br/>
`/user/{id}`<br/>

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
                    "Username":"updated username",
                    "email":"Update Email address
                    "
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
            "username":"update user name",
            "uuid":"somestringofnumbers",
            "email":"update@email.com"
      }`
      
* **Error Response:**
    * **Code:**  417
      **Content:** `{"Error":"Missing Chat Client Token"}`
      
    * **Code:**  
      **Content:** `{}`

* **Example** 

