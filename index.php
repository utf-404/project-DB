<?php
session_start();

$user = 'S13_502';
$pw = 'pw1234';
$servername = '203.249.87.57/orcl';

$conn = oci_connect($user, $pw, $servername);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// 사용자가 이미 로그인한 경우, 해당 사용자를 마이페이지로 리디렉션
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'get') {
            header("Location: mypage_get.php");
            exit;
        }
    }
}

if (isset($_SESSION['volunteer_loggedin']) && $_SESSION['volunteer_loggedin'] === true) {
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'give') {
            header("Location: mypage_give.php");
            exit;
        }
    }
}

$sql = "SELECT * FROM NoticeBoard";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

$posts = [];

while ($row = oci_fetch_assoc($stmt)) {
    $posts[] = $row;
}

// 로그아웃 처리
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>봉사 모집</title>
    <link rel="stylesheet" type="text/css" href="common.css"/>
    <link rel="stylesheet" type="text/css" href="home.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header-left">
        <div class="header-sitename">
            <span class="boldtext">H</span>OUR
            <span class="boldtext">H</span>ANDS
            <span class="boldtext">H</span>ELP
        </div>
    </div>
    <div class="header-right">
    <div class="dropdown header-button">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
          <!-- get 로그인한 경우 -->
          <a href="index.php?logout=true" class="header-button"><button class="header-button">로그아웃</button></a>
          <a href="mypage_get.php"><button class="header-button">마이페이지</button></a>
        <?php elseif (isset($_SESSION['volunteer_loggedin']) && $_SESSION['volunteer_loggedin'] === true) : ?>
          <!-- give 로그인한 경우 -->
          <a href="index.php?logout=true" class="header-button"><button class="header-button">로그아웃</button></a>
          <a href="mypage_give.php"><button class="header-button">마이페이지</button></a>
          <?php else : ?>
          <!-- 로그인하지 않은 경우 -->
          <a href="loginChoice.php"></a>
          <div class="dropdown header-button">
            로그인
            <div class="dropdown-content">
              <div>
                <a href="login_form_give.html" id="donor-login"></a>
              </div>
              <div>
                <a href="login_form_get.html" id="bfcy-login"></a>
              </div>
            </div>
          
    <?php endif; ?>
    <a href="review.html"><button class="header-button">리뷰</button></a>
        </div>
      </div>
    </div>
</div>

</header>
    </header>
    <div class="banner"></div>
    
    <!-- 게시물 추가 부분 -->
    <section class="add-post">
      <h2>게시물</h2>
      <div class="add-post-wrapper">
      <form id="add-post-form" method="POST" action="notice.php">
          <div class="form-wrapper">
            <div class="form-left">
              <table id="add-post-meta">
                <tr>
                  <td><label for="post-title">제목</label></td>
                  <td><input type="text" id="post-title" name="post-title" placeholder="게시물 제목"/></td>
                </tr>
                <tr>
                  <td><label for="volunteer-field">분야</label></td>
                  <td><select id="volunteer-field" name="volunteer-field">
                    <option value="환경개선">환경개선</option>
                    <option value="사회복지">사회복지</option>
                    <option value="교육제공">교육제공</option>
                    <option value="문화예술">문화예술</option>
                    <option value="정서지원">정서지원</option>
                    <option value="재능활용">재능활용</option>
                    <option value="레저/스포츠">레저/스포츠</option>
                    <option value="식사지원">식사지원</option>
                    <option value="재난재해">재난재해</option>
                    <option value="IT지원">IT지원</option>
                    <option value="사회상담">사회상담</option>
                    <option value="행사지원">행사지원</option></select
                  ></td>
                </tr>
                <tr>
                  <td><label for="volunteer-date">날짜</label></td>
                  <td><input
                      type="date"
                    id="volunteer-date"
                    name="volunteer-date"
                  /></td>
                </tr>
                <tr>
                  <td><label for="location">지역</label></td>
                  <td><select id="location-field" name="location-field">
                    <option value="서울">서울</option>
                    <option value="경기도">경기도</option>
                    <option value="인천">인천</option>
                    <option value="충남">충남</option>
                    <option value="충북">충북</option>
                    <option value="대전">대전</option>
                    <option value="경북">경북</option>
                    <option value="대구">대구</option>
                    <option value="경남">경남</option>
                    <option value="부산">부산</option>
                    <option value="전북">전북</option>
                    <option value="전남">전남</option>
                    <option value="광주">광주</option>
                    <option value="강원">강원</option>
                    <option value="제주">제주</option></select
                  > </td>
                </tr>
              </table>
            </div>
            <div class="form-right">
              <label for="post-content">내용</label>
              <textarea id="post-content" name="post-content" placeholder="타인의 저작물을 무단 도용하거나 적절하지 않은 표현이 포함될 시 임의로 삭제될 수 있습니다."></textarea>
              <div class="agreement-section">
                <p>개인정보 수집 ‧ 이용 ‧ 제공 동의서</p><br>
                <p>본인은 귀사에 이력서를 제출함에 따라 [개인정보 보호법] 제15조 및 제17조에 따라 아래의 내용으로 개인정보를 수집, 이용 및 제공하는데 동의합니다.<br>

                    □ 개인정보의 수집 및 이용에 관한 사항
                    - 수집하는 개인정보 항목 (이력서 양식 내용 일체) : 성명, 주민등록번호, 전화번호,
                    주소, 이메일, 가족관계, 학력사항, 경력사항, 자격사항 등과 그 外 이력서 기재 내용
                    일체<br>
                    - 개인정보의 이용 목적 : 수집된 개인정보를 사업장 신규 채용 서류 심사 및 인사서
                    류로 활용하며, 목적 외의 용도로는 사용하지 않습니다.<br>
              
                    □ 개인정보의 보관 및 이용 기간
                    - 귀하의 개인정보를 다음과 같이 보관하며, 수집, 이용 및 제공목적이 달성된 경우
                    [개인정보 보호법] 제21조에 따라 처리합니다.<br>
                  </p>
                </div>
                <label for="agreeCheck">본인은 개인정보 수집 및 이용에 대하여 동의합니다
                  <input type="checkbox" id="agreeCheck" name="agreeCheck" value="y">
                  <input type="hidden" name="agreeCheck" value="n"> <!-- 체크 안 됐을 때 'no'로 전송 -->
                </label>
              <input type="submit" value="추가" />
            </div>
          </div>
        </form>
      </div>
    </section>
    <div class="banner1"></div>

    <section class="board">
      <h2>게시판</h2>
      <ul id="post-list" class="board-wrapper">
        <?php foreach ($posts as $post): ?>
        <li class="post-item"> <!-- 각 항목에 클래스를 추가하여 스타일 적용 -->
            <a href="notice_list.php?id=<?php echo $post['NOTICEBOARD_ID']; ?>">
                <?php echo $post['NOTICEBOARD_TITLE']; ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    </section>

    <script>

    function displayPostContent(postId) {
      const selectedPost = posts.find(post => post.id === postId);
      const postContent = document.getElementById('post-content');
      postContent.innerHTML = `<h3>${selectedPost.title}</h3><p>${selectedPost.content}</p>`;
    }

    

    function addPost(title, content) {
      const newPost = {
        id: posts.length + 1,
        title,
        content
      };
      posts.push(newPost);
      displayPostList();
    }

  



    const posts = <?php echo json_encode($posts); ?>;

    function displayPostList() {
      const postList = document.getElementById('post-list');
      postList.innerHTML = '';

      posts.forEach(post => {
        const listItem = document.createElement('li');
        const link = document.createElement('a');
        link.href = 'notice_list.php?id=' + post['NOTICEBOARD_ID'];
        link.textContent = post['NOTICEBOARD_TITLE'];
        listItem.appendChild(link);
        postList.appendChild(listItem);
      });
    }

    displayPostList();
  </script>
</body>
</html>