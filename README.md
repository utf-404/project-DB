# DB-Project

# ⭐️ Motivation

Although people have a desire to serve, it was often difficult
to find the opportunity or time to serve because the place
they wanted and the field they wanted did not match.

→ Communicate and match seamlessly / Share knowledge, share talent

---

# ⏳ HourHandsHelp

In the sense of "a touch of time helps “,
we wanted to create a simple and valuable system
by creating the importance of time donation and
a culture of donation and enabling easy service matching.

---

# 프로젝트 개요

- 테이블 간 1:1, 1:N, N:M 관계가 모두 포함된 데이터베이스를 활용하는 웹사이트
- 기부자와 수혜자의 조건을 실시간으로 확인하고 관리할 수 있는 웹사이트
- 수혜자가 원하는 봉사활동을 등록하면, 그것을 바탕으로 기부자가 실시간으로 선택할 수 있는 웹사이트
- 기부자와 수혜자를 따로 관리하며 겹치지 않고 서로의 서비스를 받을 수 있는 웹사이트

---

### 🧑🏻‍💻 프로젝트 팀원

<aside>
👨🏻‍💻 박준렬(팀장) → BE/FE

</aside>

<aside>
👨🏻‍💻 김건희 → BE

</aside>

<aside>
👩🏻‍💻 유민아 → FE

</aside>

---

## 목차

- 사용 방법
- 요구사항
- E-R 다이어그램
- 실행 화면과 기능 설명

---

## ⚙️ 사용 방법

- [http://203.249.87.58/class_502/502_S13/php_oracle/index.php](http://203.249.87.58/class_502/502_S13/php_oracle/index.php) 에 접속하여 해당 프로젝트의 내용을 확인할 수 있다. 하지만 학기 중 데이터 베이스 및 실습 수업 시간에 진행한 프로젝트이며, 이를 위해 제공 받은 리눅스 서버와 오라클 DB가 시간이 지나면 사용이 불가능할 수 있다.

---

## 📍 요구사항

- 회원 정보는  **수혜자 ID** 와 **기부자 ID** 두 가지로 분류한다.
- 수혜자 회원가입 시 **수혜자ID**, 이름, 전화번호, 이메일, 비밀번호를 필수 입력하고 장애인 인증과 고령자(나이)를 선택 입력한다.
- 기부자 회원가입 시 **기부자 ID**, 이름, 전화번호, 이메일, 비밀번호를 필수 입력하고 장애인 인식 교육 여부를 선택 입력한다.
- 희망봉사등록 시 **봉사이름ID**로 구분하고, 카테고리, 봉사날짜, 제목, 내용, 동의서를 필수 입력하고 **수혜자ID**를 외래키로 받는다.
- 리뷰 등록 시 **리뷰ID**로 구별하고, **수혜자ID**와 **봉사이름ID**를 외래키로 받아오며 평점, 제목, 내용을 필수 입력하고 체크리스트를 선택 입력한다.
- 신청 등록 시 **기부자ID**, **봉사이름ID**를 복합키(주키)로 사용하며 신청날짜를 자동으로 저장한다.

---

## E-R 다이어그램

<img width="692" alt="스크린샷 2024-02-26 오후 10 43 24" src="https://github.com/utf-404/project-DB/assets/138092660/53468d58-0a75-4a6c-b985-39b14353c365">


---

## 🖥️ 실행 화면과 기능 설명

### Index
![스크린샷 2024-02-26 오후 10 58 45](https://github.com/utf-404/project-DB/assets/138092660/eceb9969-7293-42cf-a901-d671e9b4a2a4)



→ 우측 상단의 버튼을 통해 로그인을 진행할 수 있으며, 리뷰로 이동할 수 있습니다.

### 로그인 페이지

![스크린샷 2024-02-26 오후 10 59 14](https://github.com/utf-404/project-DB/assets/138092660/bd47b2fe-ec32-4283-8b2e-38a2630d1f89)


→ 로그인 버튼을 클릭하면 기부자와 수혜자로 나뉘어 로그인을 진행할 수 있도록 하였습니다.

### 로그인 페이지 / 회원가입 페이지 이동

![스크린샷 2024-02-26 오후 10 59 30](https://github.com/utf-404/project-DB/assets/138092660/efcbd893-1638-4c65-a411-8e32e952af8f)


→ 수혜자와 기부자의 로그인 페이지가 각각 존재하며 회원 가입 페이지를 각각 설정해두었습니다. 아래의 회원 가입 링크를 클릭하면 회원가입 페이지로 이동하게 됩니다.

### 회원가입 자세히 보기

![스크린샷 2024-02-26 오후 10 59 36](https://github.com/utf-404/project-DB/assets/138092660/65778e11-eab0-4654-b5b8-6f67a0f64bd7)


→ 회원가입도 마찬가지로 기부자와 수혜자를 각각 나누어 가입할 수 있도록 설정하였으며, 로그인 페이지에서 넘어갈때 수혜자와 기부자 중 어떤 것으로 가입할지 다시 한번 확인하기 위해 이러한 형태의 회원 가입 시스템을 만들었습니다.

### 회원가입 페이지(기부자)

![스크린샷 2024-02-26 오후 10 59 44](https://github.com/utf-404/project-DB/assets/138092660/d8e820a7-3934-4449-bbb2-54fc3e515f35)


→ 기부자 회원가입 시 장애인 인식 교육 여부를 제외한 나머지는 필수 입력이며, 장애인 인식 교육 여부를 선택하여 체크할 수 있도록 만들었습니다. 

### 회원가입 페이지(수혜자)

![스크린샷 2024-02-26 오후 10 59 53](https://github.com/utf-404/project-DB/assets/138092660/fbaa5688-44e0-4458-988e-0a1e6a8ef53b)


→ 수혜자 회원가입 시 장애인과 고령자를 제외한 나머지는 필수 입력하도록 하였고, 장애인과 고령자는 선택 입력하고 체크할 시 각각의 맞는 것을 입력할 수 있도록 만들었으며 선택하지 않으면 Null 값이 들어가도록 하였습니다.

### 로그인 시 마이페이지

![스크린샷 2024-02-26 오후 11 00 16](https://github.com/utf-404/project-DB/assets/138092660/ffb513da-ee8d-4c9d-bf72-8830367bd33c)


→ 기부자로 로그인 했을 경우 화면입니다. 회원 정보를 불러와 그대로 표기 하도록 하였으며, 수혜자도 로그인 시 같은 모습으로 보이도록 마이페이지를 만들었습니다.

### 리뷰

![스크린샷 2024-02-26 오후 11 00 31](https://github.com/utf-404/project-DB/assets/138092660/62b6847d-a03f-4de6-9da6-e21afdd3c117)


→ 수혜자가 받은 서비스를 리뷰를 통해 남길 수 있도록 하였으며, 아이디와 제목, 평점, 체크리스트, 내용을 작성할 수 있도록 만들었습니다. 다른 수혜자 또는 기부자들이 리뷰를 통해 각각의 서비스에 대한 것들에 대한 평점을 확인하여 신청할 수 있도록 하기 위해 제작하였습니다.

![스크린샷 2024-02-26 오후 11 00 43](https://github.com/utf-404/project-DB/assets/138092660/2b598809-a332-4455-a788-4fed87fabd33)


### 게시물 작성 / 게시판 목록

![스크린샷 2024-02-26 오후 11 00 56](https://github.com/utf-404/project-DB/assets/138092660/d36bc189-2b09-467d-ab05-acf9560ee569)


→ Index화면에 같이 구성하였으며 게시물을 바로 작성할 수 있도록 하였습니다. 바로 밑에 게시판 목록을 확인할 수 있으며 클릭시 자세한 내용을 확인할 수 있도록 하였습니다. 게시물 작성 시 ID와 분야, 날짜, 지역 내용 마지막으로 동의서를 읽고 확인하여 보다 안전하게 서비스를 제공받고 할 수 있도록 만들었습니다. 여기서 각각의 대표적인 분야를 선택하여 카테고리를 나누었고 날짜와 지역을 통해 편의성을 올렸습니다. 

![스크린샷 2024-02-26 오후 11 01 09](https://github.com/utf-404/project-DB/assets/138092660/23ee0baa-3fd2-48ff-850e-c0e63226688d)


→ 게시물을 클릭시 볼 수 있는 화면이며 위의 아이디는 게시물 목록 순서이며 자동 증가하도록 만들었습니다. 그리고 신청하기 버튼을 누르면 신청이 되며 수정하기와 삭제하기를 통해 게시물을 조정할 수 있도록 하였습니다. 마찬가지로 카테고리와 날짜 지역 동의서 선택을 확일할 수 있도록 만들었습니다. 

---

## 기타사항

- 지도교수 : 김영철 교수님 [http://selab.hongik.ac.kr/](http://selab.hongik.ac.kr/)
- 사용언어 및 개발환경 : <img src="https://img.shields.io/badge/html5-E34F26?style=for-the-badge&logo=html5&logoColor=white"> <img src="https://img.shields.io/badge/css-1572B6?style=for-the-badge&logo=css3&logoColor=white"> <img src="https://img.shields.io/badge/javascript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"> <img src="https://img.shields.io/badge/oracle-F80000?style=for-the-badge&logo=oracle&logoColor=white"> <img src="https://img.shields.io/badge/mysql-4479A1?style=for-the-badge&logo=mysql&logoColor=white"> <img src="https://img.shields.io/badge/php-777BB4?style=for-the-badge&logo=mysql&logoColor=white"> <img src="https://img.shields.io/badge/apach-D22128?style=for-the-badge&logo=mysql&logoColor=white"> <img src="https://img.shields.io/badge/visualstudiocode-007ACC?style=for-the-badge&logo=mysql&logoColor=white">
