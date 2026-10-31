# PHP Login — SQL Injection Lab

XAMPP(Apache + MySQL) 환경에서 로그인 폼을 만들고, **SQL Injection으로 인증을 우회**한 뒤 **Prepared Statement로 막는** 과정을 정리한 실습입니다.

## 시나리오

문자열을 이어 붙여 쿼리를 만들면 이렇게 우회됩니다.

```php
// 취약한 방식 (예시)
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
```

아이디에 `admin' -- ` 또는 비밀번호에 `' OR '1'='1` 을 넣으면 조건이 항상 참이 되어 로그인이 통과됩니다.

## 방어

`login_process.php`는 **Prepared Statement + 파라미터 바인딩**으로 작성했습니다.

```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param('ss', $username, $password);
```

쿼리 구조(`?`)와 사용자 입력이 분리되므로, 입력에 무엇을 넣어도 SQL 문법으로 해석되지 않습니다.

> 추가 개선점: 비밀번호는 평문이 아니라 `password_hash()` / `password_verify()`로 해시 저장·검증해야 합니다.

## 실행 (로컬)

1. XAMPP에서 Apache, MySQL 실행
2. 이 폴더를 `htdocs/` 아래에 둠
3. phpMyAdmin에서 DB(`my_db`)와 `users` 테이블 생성 후 테스트 계정 삽입
4. 브라우저에서 `http://localhost/php-login-sqli/login.html` 접속

> 주의: 로컬 실습 전용. `root` / 빈 비밀번호는 XAMPP 기본값이며 공개 서버에 그대로 쓰면 안 됩니다.
