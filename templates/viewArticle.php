<?php include "templates/include/header.php" ?>

			<div class="row">
				<div class="col-sm-8 blog-main">
					<div class="blog-header">
							<h1 class="blog-post-title">
								<?php echo htmlout($results['article']->title)?>
							</h1>
							<div class="description" style="font-style: italic;">
								<?php echo htmlout($results['article']->summary)?>
							</div>

							<div class="content">
							<?php if ($imagePath = $results['article']->getImagePath()) { ?>
								<img id="articleImageFullsize" class="img-responsive" src="<?php echo $imagePath?>" alt="Article Image" />
							<?php } ?>
								<?php echo $results['article']->content?>
							</div>

							<p class="pubDate">Опубликовано <?php echo date('j F Y', $results['article']->publicationDate)?>
							<?php if ($results['category']) { ?>
									в категории: <a href="./?action=archive&amp;categoryId=<?php echo $results['category']->id?>"><?php echo htmlout($results['category']->name) ?></a>
							<?php } ?>
							</p>
					</div>

					<nav aria-label="back">
						<ul class="pager">
							<li class="previous"><a href="?action=archive"><span aria-hidden="true">&larr;</span>Показать все записи</a></li>
						</ul>


				</div>
			</div>

<?php include "templates/include/footer.php" ?>