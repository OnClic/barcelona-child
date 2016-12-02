<?php
/*
Template Name: Agenda New
*/
?>
<?php

$barcelona_is_pw_req = post_password_required();

get_header();

barcelona_breadcrumb();

?>
<div class="container single-container">

	<div class="row-primary sidebar-none clearfix">

		<main id="main" class="main">

			<header class="post-image">
				<div class="fimg-wrapper fimg-cl fimg-no-meta fimg-no-thumb">
					<div class="featured-image">
						<div class="fimg-inner">
							<div class="vm-wrapper">
								<div class="vm-middle">
									<h1 class="post-title">Próximos 30 días</h1>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .fimg-wrapper -->
			</header>

			<div class="posts-box posts-box-9" data-type="none_0" data-post-not="">
				<?php 
					get_agenda_next_30();
					get_agenda_dia(); 
					get_agenda_semana(); 
					get_agenda_mes(); 
				?>
			</div>
		</main>
	</div>
</div>
<?php
get_footer();