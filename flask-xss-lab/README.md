# Flask XSS Lab

Flask + Jinja2 방명록을 소재로 **Reflected / Stored XSS**가 어디서, 왜 터지는지 관찰하는 실습입니다.

## 취약 지점

- **Stored XSS** — `templates/index.html`에서 저장된 글 본문을 `{{ m.body|safe }}`로 출력합니다. `|safe`가 Jinja2의 자동 이스케이프를 꺼버려서, 글 작성 시 넣은 `<script>...</script>`가 목록을 볼 때 그대로 실행됩니다.
- **Reflected XSS** — `templates/search.html`에서 검색어를 `{{ q|safe }}`로 그대로 반사 출력합니다. `/search?q=<script>alert(1)</script>` 같은 요청이 바로 실행됩니다.

## 핵심 교훈

`|safe` 필터(또는 임의의 "이스케이프 끄기")는 입력을 **신뢰할 수 있을 때만** 써야 합니다.
기본 동작(자동 이스케이프)을 유지하고, 정말 HTML을 넣어야 한다면 서버에서 허용 태그만 남기는 sanitizing을 거쳐야 합니다.

## 실행 (로컬)

```bash
pip install flask
python app.py   # 또는 flask run
```

> 주의: XSS 실습은 반드시 로컬에서만. 외부 공개 서버에서 테스트 금지.
