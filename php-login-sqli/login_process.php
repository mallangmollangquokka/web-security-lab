<?php
// db 연결
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "my_db";
$db_port = 3306;

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
// new mysqli(호스트, 사용자, 비번, db이름, 포트번호)
// new mysqli가 db 연결 객체를 만들어 $conn에 넣음. 이후 모든 쿼리는 $conn 을 통해 실행
if($conn->connect_error){
    die("데이터베이스 연결 실패: " . $conn->connect_error); // connect_error로 수정
}
// 접속 실패 시 즉시 종료

// login.html에서 POST 방식으로 보낸 데이터 받기
$username = $_POST['username'];
$password = $_POST['password'];
// 값이 없으면 notice 오류남. 실무에선 isset()으로 값 있는지 확인하고 처리

// [방어] Prepared Statement로 쿼리 구조와 값을 분리한다.
// 문자열을 그대로 이어 붙이면 ' OR '1'='1 같은 입력으로 인증이 우회된다.
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
if (!$stmt) {
    die("Prepare 실패: " . $conn->error);
}
$stmt->bind_param('ss', $username, $password); // 둘 다 string
$stmt->execute();
// 파라미터가 쿼리 구조와 분리되므로 SQL Injection이 차단된다.
// get_result()가 있으면 사용 (mysqlnd 사용 시)
$result = $stmt->get_result();


// 결과 확인
if($result->num_rows > 0){ // num_rows로 수정
    // 일치하는 사용자 있으면 (결과 행이 1개 이상이면)
    echo "<h2>로그인 성공!</h2>";
    echo "<p>$username 님, 환영합니다.</p>";
}else{
    echo "<h3>로그인 실패</h3>";
    echo "<p>아이디 또는 비밀번호가 올바르지 않습니다.</p>";
    echo "<a href='login.html'>다시 시도하기</a>";
}

// DB 연결 종료
$conn->close();
?>
