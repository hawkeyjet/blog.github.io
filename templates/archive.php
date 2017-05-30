<?php include "templates/include/header.php" ?>

			<h1>Статьи</h1>

			<ul id="headlines" class="archive">
<?php foreach ($results['articles'] as $article) { ?>
				<li>
					<h2>
						<span class="pubDate"><?php echo date('j F Y', $article->publicationDate)?></span><a href=".?action=viewArticle&amp;articleId=<?php echo $article->id?>"><?php echo htmlout($article->title)?></a>
					</h2>
					<p class="summary"><?php echo htmlout($article->summary)?></p>
				</li>
<?php } ?>
			</ul>

			<p>Количество статей: <?php echo $results['totalRows']?></p>
			<p><a href="./">Вернуться на Главную</a></p>

<?php include "templates/include/footer.php" ?>