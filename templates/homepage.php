<?php include "templates/include/header.php" ?>

			<div class="row">
				<div class="col-sm-8 blog-main">
					<div class="jumbotron">
  					<h1>Виджет Блог</h1>
  					<p>Блог — это не только CMS с набором плагинов, заработок в интернете и перекрёстные ссылки, но ещё и большая польза для самого автора. При условии, что он будет заниматься своим сайтом так, как будто это серьёзный проект или книга. Блог — это крутой личный блокнот, который читают другие люди. Именно наличие читающей и обсуждающей авторские мысли аудитории приносит ни с чем не сравнимое удовольствие.</p>
					</div>
					<?php foreach ($results['articles'] as $article) { ?>
						<div class="blog-post">
							<h2 class="blog-post-title">
								<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
									<?php echo htmlout($article->title)?>
								</a>
							</h2>
							<p class="blog-post-meta">
								<span class="pubDate"><?php echo date('j F Y', $article->publicationDate)?></span>
								<?php if ($article->categoryId) { ?>
									в категории: <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId ?>"><?php echo htmlout($results['categories'][$article->categoryId]->name) ?></a></span>
								<?php } ?>
							</p>
							<div class="summary clearfix">
								<?php if ($imagePath = $article->getImagePath(IMG_TYPE_THUMB)) { ?>
									<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
									<img class="articleImageThumb img-responsive" src="<?php echo $imagePath?>" alt="Article Thumbnail" /></a>
								<?php } ?>
								<p><?php echo htmlout($article->summary)?></p>
							</div>
						</div>
					<?php } ?>
					<a class="btn-bottom btn btn-primary btn-lg" role="button" href=".?action=archive">Посмотреть все записи</a>
				</div>




				<?php include "templates/include/sidebar.php" ?>

			</div>



<?php include "templates/include/footer.php" ?>

