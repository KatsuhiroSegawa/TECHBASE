<header class="header">
	<div class="header-title">
		<span><a href="http://tt-573.99sv-coco.com/top.php" target=_self>企業研究掲示板</a></span>
	</div>
	<div class="header-panel">
		<ul>
			<?php if(empty($_SESSION[NAME])): ?>
			<li><a href='http://tt-573.99sv-coco.com/signup.php' target=_self>新規登録</a></li>
			<li><a href='http://tt-573.99sv-coco.com/login.php' target=_self>ログイン</a></li>
			<?php else: ?>
			<li><a href='http://tt-573.99sv-coco.com/mypage.php' target=_self>マイページ</a></li>
			<li><a href='http://tt-573.99sv-coco.com/logout.php' target=_self>ログアウト</a></li>
		<?php endif; ?></ul>
	</div>
	<div class="header-welcome">
		<span><?php if(!empty($_SESSION[NAME])) echo "ようこそ、$_SESSION[NAME]さん。"; ?></span>
	</div>
</header>
