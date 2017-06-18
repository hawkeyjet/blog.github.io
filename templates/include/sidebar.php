				<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
					<div class="sbmod">
						<div class="sidebar-module sidebar-module-inset">
							<h4>Виджет Блог</h4>
							<p>Дипломная работа 2017, Чернигов</p>
						</div>
						<div class="sidebar-module">
							<h4>Категории</h4>
							<ol class="list-unstyled">
								<?php foreach ($results['categories'] as $category) { ?>
										<li><a href=".?action=archive&categoryId=<?php echo $category->id ?>">
														<?php echo htmlout($category->name); ?>
												</a>
										</li>
									<?php } ?>
							</ol>
						</div>
					</div>
				</div>
