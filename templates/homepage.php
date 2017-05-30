<?php include "templates/include/header.php" ?>

			<ul id="headlines">
<?php foreach ($results['articles'] as $article) { ?>
				<li>
					<h2>
						<span class="pubDate"><?php echo date('j F', $article->publicationDate)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlout($article->title)?></a>
					</h2>
					<p class="summary"><?php echo htmlout($article->summary)?></p>
				</li>
<?php } ?>
			</ul>

			<p><a href="./?action=archive">Посмотреть все статьи</a></p>

<?php include "templates/include/footer.php" ?>

