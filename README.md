<img width="1013" height="578" alt="image" src="https://github.com/user-attachments/assets/52efe107-250b-4f7b-a505-0680347275aa" /># ขั้นตอนการทดลอง
**1.สร้าง Database mygames**  
<img width="281" height="301" alt="image" src="https://github.com/user-attachments/assets/734297fe-b103-4c50-b87e-a163e9a9e945" />

**2.ทำการสร้างโฟลเดอร์ mygames_api ใน C:\xampp\htdocs\mygames_api**  
<img width="1134" height="608" alt="image" src="https://github.com/user-attachments/assets/b489652e-6517-433e-8944-0948f82e5bf5" />

**3.ทำสร้างโฟลเดอร์ย่อยและไฟล์ในโฟลเดอร์ mygames_api**  
### โครงสร้างข้างในโฟลเดอร์ mygames_api 
```
mygames_api/  
│  
├── public/                 # ไฟล์ที่ client เรียกตรงๆ (Front Controller)  
│     ├── .htaccess           # rewrite URL -> index.php (optional ใช้ mod_rewrite)  
│     └── index.php           # Router + Endpoint หลัก  
│  
└── src/                    # Business logic / Core code  
      ├── Database.php        # จัดการ connection PDO  
      ├── GameController.php  # CRUD logic (get, post, put, patch, delete)  
      └── Response.php        # Utility class สำหรับส่ง JSON response  
  ```
### อธิบายแต่ละไฟล์  

* public/index.php
  * เป็น Front Controller (Router)
  * อ่าน $_SERVER['REQUEST_METHOD'] + PATH_INFO
  * ตัดสินใจว่าจะเรียก method ของ GameController ไหน (GET/POST/PUT/PATCH/DELETE)
  * ส่ง response JSON กลับ
* src/Database.php
  * class Database
  * มี connect() → return PDO connection
  * ใช้ try/catch จัดการ error connection
* src/GameController.php
  * จัดการข้อมูลเกม
  * getAllGames() / getGame() / createGame() / updateGame() / patchGame() / deleteGame()
  * ใช้ prepared statement ปลอดภัยจาก SQL Injection
  * รองรับ price แบบ DECIMAL(10,2)
* src/Response.php
  * class Response
  * ฟังก์ชัน json($data, $statusCode=200)  
  * ใส่ header Content-Type: application/json; charset=utf-8  
  * จัดการ error handling (400, 404, 500, ฯลฯ)  
* .htaccess (ใน public/) (ถ้าเปิด mod_rewrite)  
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```
ทำให้ URL http://localhost/mygames_api/public/id/1 → ไปที่ index.php  
👉 โครงสร้างนี้คือแบบ มาตรฐาน MVC-like lightweight REST API ที่ใช้ได้ใน XAMPP  
* public/ = ส่วนที่โลกภายนอกเข้าถึง  
* src/ = business logic (Controller/Database/Helper)

# การทดสอบ API โดยใช้โปรแกรม Postman
**1.สร้าง Collection ขึ้นมาใหม่ชื่อ_ mygames_api_test**  
**2.สร้าง Request CRUD METHOD ที่ใช้ทดสอบ**  
* GET
* POST
* PUT
* PATCH
* DELETE

**3.ทำการทดสอบ CRUD METHOD แต่ละอัน**  
* GET โดยไม่ระบุไอดี
  * ใช้ GET http://localhost/mygames_api/public/

**ผลลัพธ์**
```
[
    {
        "id": 1,
        "name": "Pixel Quest",
        "publisher": "Indie Studio",
        "category": "single_player",
        "price": "29.99",
        "rating": "7.85"
    },
    {
        "id": 2,
        "name": "Shadow Realm",
        "publisher": "Square Enix",
        "category": "single_player",
        "price": "39.99",
        "rating": "8.95"
    },
    {
        "id": 3,
        "name": "Ancient Scrolls",
        "publisher": "Bethesda",
        "category": "single_player",
        "price": "49.99",
        "rating": "9.10"
    },
    {
        "id": 4,
        "name": "Glory Arena",
        "publisher": "Riot Games",
        "category": "multiplayer",
        "price": "59.99",
        "rating": "9.00"
    },
    {
        "id": 5,
        "name": "Galaxy Raiders",
        "publisher": "Bandai Namco",
        "category": "multiplayer",
        "price": "44.99",
        "rating": "8.15"
    },
    {
        "id": 6,
        "name": "Zombie Survival",
        "publisher": "Valve",
        "category": "multiplayer",
        "price": "34.99",
        "rating": "8.05"
    },
    {
        "id": 7,
        "name": "Street Football",
        "publisher": "EA Sports",
        "category": "sport",
        "price": "24.99",
        "rating": "8.40"
    },
    {
        "id": 8,
        "name": "Tennis Pro Tour",
        "publisher": "Konami",
        "category": "sport",
        "price": "19.99",
        "rating": "7.95"
    },
    {
        "id": 9,
        "name": "Battle Ops",
        "publisher": "Activision",
        "category": "shooting",
        "price": "54.99",
        "rating": "8.20"
    },
    {
        "id": 10,
        "name": "Sniper Elite X",
        "publisher": "Rebellion",
        "category": "shooting",
        "price": "64.99",
        "rating": "8.65"
    },
    {
        "id": 11,
        "name": "Combat Strike",
        "publisher": "Tencent",
        "category": "shooting",
        "price": "74.99",
        "rating": "8.75"
    },
    {
        "id": 12,
        "name": "Farm Life",
        "publisher": "Zynga",
        "category": "casual",
        "price": "14.99",
        "rating": "7.35"
    },
    {
        "id": 13,
        "name": "Casual Town",
        "publisher": "Supercell",
        "category": "casual",
        "price": "9.99",
        "rating": "7.50"
    },
    {
        "id": 14,
        "name": "Puzzle Mania",
        "publisher": "King",
        "category": "puzzle",
        "price": "12.99",
        "rating": "7.60"
    },
    {
        "id": 15,
        "name": "Mind Blocks",
        "publisher": "Mojang",
        "category": "puzzle",
        "price": "22.99",
        "rating": "9.20"
    },
    {
        "id": 16,
        "name": "Speed Horizon",
        "publisher": "Ubisoft",
        "category": "racing",
        "price": "49.99",
        "rating": "7.95"
    },
    {
        "id": 17,
        "name": "Pro Racing League",
        "publisher": "Codemasters",
        "category": "racing",
        "price": "59.99",
        "rating": "8.55"
    },
    {
        "id": 18,
        "name": "Mystery Island",
        "publisher": "Nintendo",
        "category": "adventure",
        "price": "69.99",
        "rating": "9.05"
    },
    {
        "id": 19,
        "name": "Dragon World",
        "publisher": "Capcom",
        "category": "adventure",
        "price": "79.99",
        "rating": "9.25"
    },
    {
        "id": 20,
        "name": "Jungle Adventure",
        "publisher": "SEGA",
        "category": "adventure",
        "price": "39.99",
        "rating": "8.40"
    }
]
```
### การใช้ GET
* GET โดยระบุไอดี
   * ใช้ GET http://localhost/mygames_api/public/id/1

**ผลลัพธ์:**
<img width="1094" height="823" alt="image" src="https://github.com/user-attachments/assets/cb7009f0-69dc-45a2-8aa5-03ab54d616b8" />



* กรณี GET id ที่ไม่มีอยู่ใน database
  * ใช้ GET http://localhost/mygames_api/public/id/999

**ผลลัพธ์:**
<img width="965" height="529" alt="image" src="https://github.com/user-attachments/assets/fa467228-961f-4986-a089-fba1b9ae1b16" />  

* กรณีใช้เพื่อ filter จากชื่อเกม
  * ใช้ GET http://localhost/mygames_api/public/name/Jungle Adventure

**ผลลัพธ์:**  
<img width="1176" height="556" alt="image" src="https://github.com/user-attachments/assets/2a0da272-4e88-450f-9470-e88b9f7792bb" />  

* กรณีใช้เพื่อ filter จากประเภทเกม
  * ใช้ GET http://localhost/mygames_api/public/category/single player

**ผลลัพธ์:**
<img width="1227" height="713" alt="image" src="https://github.com/user-attachments/assets/51a01ed9-0896-448a-b4c0-57cc548102fe" />  

* กรณีใช้เพื่อ filter จากชื่อผู้จัดจำหน่ายเกม
  * ใช้ GET http://localhost/mygames_api/public/publisher/EA Sport

**ผลลัพธ์:**
<img width="1162" height="549" alt="image" src="https://github.com/user-attachments/assets/817ee1fd-eb43-4641-b4f4-6ea05edca14e" />  

### การใช้ POST  
* ใช้ POST ในการ INSERT ข้อมูลเข้าไปที่ database
  > ใช้ POST
    >> Body
    >>> JSON
    ```
    {
    "name":"Ninja V",
    "publisher":"Peerapong",
    "category":"adventure",
    "price": 24.99,
    "rating": 8.60
    }
    ```

**ผลลัพธ์:**
* ผลลัพธ์การ POST
<img width="1055" height="695" alt="image" src="https://github.com/user-attachments/assets/3f7fc0ad-49f9-49b5-add0-3a8246a86226" />  

* เช็คข้อมูลใน database
<img width="530" height="366" alt="image" src="https://github.com/user-attachments/assets/bdfbfeb8-fbf3-47ad-ae17-16f72741862b" />

### การใช้ PUT (ต้องระบุ id ข้อมูล)
* ใช้ PUT ในการ UPDATE ข้อมูลใน database โดยเป็นการเปลี่ยนข้อมูลหม่ทั้งหมดลงเขียนทับข้อมูลเดิม
  > PUT http://localhost/mygames_api/public/id/24
  >> Body
  >>> JSON
```
{
    "name":"NINJA V",
    "publisher":"Peerapong",
    "category":"adventure",
    "price": 20.00,
    "rating": 7.60
}
```  
**ผลลัพธ์:**
* ผลลัพธ์การ PUT
<img width="1071" height="769" alt="image" src="https://github.com/user-attachments/assets/889088f2-d609-4acc-aafb-85dac237fe21" /> 

* เช็คข้อมูลใน database
<img width="1100" height="786" alt="image" src="https://github.com/user-attachments/assets/ffd84a84-6c21-4c04-889a-57e9e0795020" />

### การใช้ PATCH (ต้องระบุ id ข้อมูล)
 * ใช้ PATCH ในการ UPDATE ข้อมูลใน database โดยเป็นการเปลี่ยนข้อมูลเฉพาะ Field ที่เลือกไว้เท่านั้น
 > PATCH http://localhost/mygames_api/public/id/24
  >> Body
  >>> JSON
```
{
    "price": 15.99,
    "rating": 8.20
}
```  
**ผลลัพธ์:**
* ผลลัพธ์การ PATCH  
<img width="1105" height="773" alt="image" src="https://github.com/user-attachments/assets/bbb9b25a-09d6-46f4-b7b8-84b423a7f7e6" />

### การใช้ DELETE (ต้องระบุ id ข้อมูล)
 * DELETE ใช้ลบข้อมูลใน database
   * DELETE http://localhost/mygames_api/public/id/24

**ผลลัพธ์:**  
* ผลลัพธ์การ DELETE
<img width="1081" height="731" alt="image" src="https://github.com/user-attachments/assets/ebdd6fad-8ab5-4098-b6de-4867d1c24685" />  

เช็คข้อมูลใน database
<img width="1259" height="769" alt="image" src="https://github.com/user-attachments/assets/ffda7bfc-7a24-40f4-a5df-88733abdc588" />

### การ Error Handle กรณีระบุ URL ไม่ถูกต้อง
1. Endpoint ไม่ถูกงต้อง
<img width="1013" height="578" alt="image" src="https://github.com/user-attachments/assets/8f9888a9-6d4f-46ba-ad6e-62abb7c102df" />

2. ระบุ ID ไม่ถูกต้อง
<img width="1254" height="628" alt="image" src="https://github.com/user-attachments/assets/ec8f7c6d-20d5-4aa5-9b54-06667f0017e4" />

3. Filter ชื่อเกมไม่ถูกต้อง
<img width="1256" height="641" alt="image" src="https://github.com/user-attachments/assets/e4583dd9-e92c-42d6-abdb-8b2a3d8ed264" />

4. Filter ประเภทของเกมไม่ถูกต้อง
<img width="1089" height="578" alt="image" src="https://github.com/user-attachments/assets/a83d55e1-321f-4cfc-9051-143d9f64d750" />

5. Filter ชื่อผู้จัดจำหน่ายไม่ถูกต้อง
<img width="1253" height="601" alt="image" src="https://github.com/user-attachments/assets/bad67d99-d009-41d0-946d-a7e6f50350f4" />

6. กรณีที่ PUT  โดยที่ใส่ URL ไม่ถูกต้อง
<img width="1269" height="624" alt="image" src="https://github.com/user-attachments/assets/807ee1f9-d6a0-47c9-8368-c180eec5e7fe" />

7. กรณี PATCH โดยที่ใส่ URL ไม่ถูกต้อง
<img width="1257" height="601" alt="image" src="https://github.com/user-attachments/assets/06d59a3b-5e65-4dfb-bfd1-10355e93b3ca" />

8.กรณี DELETE โดยที่ใส่ URL ไม่ถูกต้อง
<img width="1258" height="689" alt="image" src="https://github.com/user-attachments/assets/31f39823-3c10-4b0f-b423-3ff27a79ff5f" />

   




