from flask import Flask, request, render_template, session, redirect, url_for, make_response

app = Flask(__name__, template_folder='templates')
app.secret_key = 'dev-secret'  # 로컬 실습용 값. 실제 서비스에서는 환경변수로 관리할 것.


@app.route('/')
def home():
    return render_template('index.html')
