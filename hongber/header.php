<!-- 상단 바 -->
<header class="nav">
    <a href="/hongber/index.php">
        <div class="logo"></div>
    </a>
    <div class="navbar_wrap">
        <div class="search_wrap">
            <form action="/hongber/php/search.php" method="GET">
                <input type="text" name="search" id="search" class="searchbox" placeholder="회원검색 (이름 or 이메일)" autocomplete="off">
                <div class="search_icon">
                    <input type="submit" value="검색" class="search_btn">
                </div>
            </form>
        </div>
        <div>
            <a href="/hongber/php/mypage.php" class="nav_a">
                <p class="nav_p">My page</p>
            </a>
        </div>
        <div>
            <a href="/hongber/php/match.php" class="nav_a">
                <p class="nav_p">Matching AD</p>
            </a>
        </div>
        <?php
        if (isset($_SESSION["hislog"]) || isset($_SESSION["mislog"])) { ?>
            <div>
                <a href="/hongber/php/spread.php" class="nav_a">
                    <p class="nav_p">Seedding AD</p>
                </a>
            </div>
        <?php } else if (isset($_SESSION["uislog"]) || isset($_SESSION['naver_access_token']) || isset($_SESSION['kakao_access_token']) || isset($_SESSION["mislog"])) { ?>
            <div>
                <a href="/hongber/php/pickup.php" class="nav_a">
                    <p class="nav_p">Picking AD</p>
                </a>
            </div>
        <?php
        } else {
        }
        //일반 광고주, 홍버, 관리자가 로그인시 로그아웃을 네비게이션바에 표시
        if (!isset($_SESSION["hislog"]) && !isset($_SESSION["uislog"]) && !isset($_SESSION["mislog"])) {
        } else {
            echo '<div>';
            echo '<a href="/hongber/php/logout.php" class="nav_a">';
            echo '<p class="nav_p">Log Out</p>';
            echo '</a>';
            echo '</div>';
        }
        //네이버 로그인시 로그아웃을 네비게이션바에 표시
        if (!isset($_SESSION['naver_access_token'])) {
        } else {
            echo '<div>';
            echo '<a href="/hongber/php/nlogout.php" class="nav_a">';
            echo '<p class="nav_p">Log Out</p>';
            echo '</a>';
            echo '</div>';
        }
        //카카오 로그인시 로그아웃을 네비게이션바에 표시
        if (!isset($_SESSION['kakao_access_token'])) {
        } else {
            echo '<div>';
            echo '<a href="/hongber/php/klogout.php" class="nav_a">';
            echo '<p class="nav_p">Log Out</p>';
            echo '</a>';
            echo '</div>';
        }
        ?>
        <?php
        if (!isset($_SESSION["hislog"]) && !isset($_SESSION["uislog"]) && !isset($_SESSION["mislog"]) && !isset($_SESSION['naver_access_token']) && !isset($_SESSION['kakao_access_token'])) {
        ?>
            <div class="dropdown">
                <button class="dropbtn">Login</button>
                <div class="dropdown-content">
                    <a href="/hongber/html/hlogin.html">
                        <p>광고주 로그인</p>
                    </a>
                    <a href="/hongber/php/ulogin.php">
                        <p>홍버 로그인</p>
                    </a>
                    <a href="/hongber/php/ber_reg2.php">
                        <p>광고주 회원가입</p>
                    </a>
                    <a href="/hongber/php/ber_reg.php">
                        <p>홍버 회원가입</p>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</header>