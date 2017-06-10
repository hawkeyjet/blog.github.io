<?php include "templates/include/header.php" ?>

			<ul id="headlines">
<?php foreach ($results['articles'] as $article) { ?>
				<li>
					<h2>
						<span class="pubDate"><?php echo date('j F', $article->publicationDate)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlout($article->title)?></a>
						<?php if ($article->categoryId) { ?>
						<span class="category">Категория: <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId?>"><?php echo htmlout($results['categories'][$article->categoryId]->name)?></a></span>
						<?php } ?>
					</h2>
					<p class="summary">
						<?php if ($imagePath = $article->getImagePath(IMG_TYPE_THUMB)) { ?>
							<a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><img class="articleImageThumb" src="<?php echo $imagePath?>" alt="Эскиз записи" /></a>
						<?php } ?>
					<?php echo htmlout($article->summary)?>
					</p>
				</li>
<?php } ?>
			</ul>

			<p><a href="./?action=archive">Посмотреть все записи</a></p>

<?php include "templates/include/footer.php" ?>

