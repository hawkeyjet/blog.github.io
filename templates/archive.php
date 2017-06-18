<?php include "templates/include/header.php" ?>



			<div class="row">
				<div class="col-sm-8 blog-main">
					<div class="blog-header">
						<h1><?php echo htmlout($results['pageHeading']) ?></h1>
					</div>
						<p>Количество записей: <?php echo $results['totalRows']?></p>
					<?php if ($results['category']) { ?>
						<p class="lead blog-description"><?php echo htmlout($results['category']->description) ?></p>
					<?php } ?>


					<?php foreach ($results['articles'] as $article) { ?>
						<div class="blog-post">
							<h2 class="blog-post-title">
								<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>">
									<?php echo htmlout($article->title)?>
								</a>
							</h2>
							<p class="blog-post-meta">
								<span class="pubDate"><?php echo date('j F Y', $article->publicationDate)?></span>
								<?php if (!$results['category'] && $article->categoryId) { ?>
									в категории: <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId?>"><?php echo htmlout($results['categories'][$article->categoryId]->name) ?></a></span>
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
				</div>
				<?php include "templates/include/sidebar.php" ?>
			</div>

<?php include "templates/include/footer.php" ?>