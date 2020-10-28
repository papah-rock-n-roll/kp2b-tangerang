# CodeIgniter 4 Framework

## Catatan KP2B-Tangerang

### Base Site URL

public $baseURL = 'http://localhost/kp2b-tangerang/'; -KP2B

public $baseURL = 'https://kp2b-tangerang.ga'; -Ardi

### Create Procedure

```sql
USE lppbmis_new;
CREATE PROCEDURE p_insertUser(
usernik VARCHAR(30),
name VARCHAR(30),
email VARCHAR(30),
password VARCHAR(60),
realpassword VARCHAR(60),
role TINYINT(3),
sts VARCHAR(15),
timestamp TIMESTAMP)
BEGIN
	SET FOREIGN_KEY_CHECKS = 0; 
	INSERT INTO
		mstr_users (`usernik`,`name`,`email`,`password`,`realpassword`,`role`,`sts`,`timestamp`)
	VALUES (`usernik`,`name`,`email`,`password`,`realpassword`,`role`,`sts`,`timestamp`); 
	SET FOREIGN_KEY_CHECKS = 1;
END
```
