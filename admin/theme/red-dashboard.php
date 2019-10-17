<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	$this->head(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">Forward</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="<?php echo $this->uri; ?>admin">Dashboard <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?php echo $this->uri; ?>signout">Sign out</a>
			</li>
		</ul>
	</div>
</nav>
<div id="red-dashboard">
	<div class="container">
		<div class="row">
			<div class="col-12" id="add-new-card">
				<form>
					<div class="card">
						<div class="card-body">
							<div class="form-row">
								<div class="col">
									<div class="form-group">
										<label for="forward-url">URL</label>
										<input type="text" id="forward-url" class="form-control" placeholder="https://">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label for="forward-slug">Slug <i>(optional)</i></label>
										<input type="text" id="forward-slug" class="form-control" placeholder="23h112">
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-outline-dark">Add new</button>
					</div>
				</form>
			</div>
			<div class="col-12" id="links-table">
				<table class="table table-striped">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">Slug</th>
				      <th scope="col">Original URL</th>
				      <th scope="col">Date</th>
				      <th scope="col">Clicks</th>
				      <th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">1</th>
				      <td>3iou2h</td>
				      <td><a href="#">https://dupa.com/</a></td>
				      <td>21-02-2019</td>
				      <td>3</td>
				      <td></td>
				    </tr>
				    <tr>
				      <th scope="row">1</th>
				      <td>3iou2h</td>
				      <td><a href="#">https://dupa.com/</a></td>
				      <td>21-02-2019</td>
				      <td>3</td>
				      <td></td>
				    </tr>
				    <tr>
				      <th scope="row">1</th>
				      <td>3iou2h</td>
				      <td><a href="#">https://dupa.com/</a></td>
				      <td>21-02-2019</td>
				      <td>3</td>
				      <td></td>
				    </tr>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->footer(); ?>