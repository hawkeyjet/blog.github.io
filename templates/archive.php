<?php include "templates/include/header.php" ?>

			<h1><?php echo htmlout($results['pageHeading']) ?></h1>
<?php if ($results['category']) { ?>
			<h3 class="categoryDescription"><?php echo htmlout($results['category']->description) ?></h3>
<?php } ?>

			<ul id="headlines" class="archive">
<?php foreach ($results['articles'] as $article) { ?>
				<li>
					<h2>
						<span class="pubDate"><?php echo date('j F Y', $article->publicationDate)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlout($article->title)?></a>
						<?php if (!$results['category'] && $article->categoryId) { ?>
						<span class="category">Категория: <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId?>"><?php echo htmlout($results['categories'][$article->categoryId]->name) ?></a></span>
						<?php } ?>
					</h2>
					<p class="summary">
						<?php if ($imagePath = $article->getImagePath(IMG_TYPE_THUMB)) { ?>
							<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><img class="articleImageThumb" src="<?php echo $imagePath?>" alt="Article Thumbnail" /></a>
						<?php } ?>
					<?php echo htmlout($article->summary)?>
					</p>
				</li>
<?php } ?>
			</ul>

			<p>Количество записей: <?php echo $results['totalRows']?></p>
			<p><a href="./">Вернуться на Главную</a></p>

<?php include "templates/include/footer.php" ?>