# Web Security Lab

웹 애플리케이션의 대표적인 취약점을 **직접 재현하고, 안전하게 고쳐 보는** 개인 실습 저장소입니다.
코드를 짜면서 "왜 취약한지"와 "어떻게 막는지"를 손으로 익히는 데 초점을 맞췄습니다.

> 주의: 모든 실습은 **로컬 환경에서만** 진행하세요. 외부에 노출된 서버에서 테스트해서는 안 됩니다.

## 구성

| 프로젝트 | 스택 | 다루는 취약점 | 방어 기법 |
|---|---|---|---|
| [`flask-xss-lab`](./flask-xss-lab) | Python · Flask · Jinja2 | Reflected / Stored XSS | 출력 이스케이프, 입력 검증 |
| [`php-login-sqli`](./php-login-sqli) | PHP · MySQL(XAMPP) | SQL Injection (로그인 우회) | Prepared Statement, 파라미터 바인딩 |

## 배운 점

- **XSS** — Jinja2의 `|safe` 필터처럼 자동 이스케이프를 끄는 순간 사용자 입력이 그대로 실행된다는 것을, 방명록 예제로 Reflected/Stored 두 경로 모두 관찰했습니다.
- **SQL Injection** — 문자열을 이어 붙여 만든 쿼리가 어떻게 로그인 인증을 우회당하는지 재현하고, Prepared Statement로 값과 쿼리 구조를 분리해 막았습니다.

## 폴더 구조

```
web-security-lab/
├─ flask-xss-lab/       # Flask 템플릿 XSS 실습
│  ├─ app.py
│  └─ templates/
│     ├─ index.html     # Stored XSS 지점
│     └─ search.html    # Reflected XSS 지점
└─ php-login-sqli/      # PHP 로그인 SQL Injection 실습
   ├─ login.html
   └─ login_process.php # Prepared Statement 적용 버전
```
