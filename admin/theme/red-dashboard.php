<?php defined('ABSPATH') or die('No script kiddies please!');
/**
 * @package Forward
 *
 * @author RapidDev
 * @copyright Copyright (c) 2019, RapidDev
 * @link https://www.rdev.cc/forward
 * @license https://opensource.org/licenses/MIT
 */
	$this->head(); $this->menu(); ?>

<div id="red-dashboard">
	<div id="dashboard-stats">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-lg-4">
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M6,16.5L3,19.44V11H6M11,14.66L9.43,13.32L8,14.64V7H11M16,13L13,16V3H16M18.81,12.81L17,11H22V16L20.21,14.21L13,21.36L9.53,18.34L5.75,22H3L9.47,15.66L13,18.64" /></svg>
						<div>
							<h1>Title</h1>
							<p>Total clicks</p>
						</div>
					</div>
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M10.6 13.4A1 1 0 0 1 9.2 14.8A4.8 4.8 0 0 1 9.2 7.8L12.7 4.2A5.1 5.1 0 0 1 19.8 4.2A5.1 5.1 0 0 1 19.8 11.3L18.3 12.8A6.4 6.4 0 0 0 17.9 10.4L18.4 9.9A3.2 3.2 0 0 0 18.4 5.6A3.2 3.2 0 0 0 14.1 5.6L10.6 9.2A2.9 2.9 0 0 0 10.6 13.4M23 18V20H20V23H18V20H15V18H18V15H20V18M16.2 13.7A4.8 4.8 0 0 0 14.8 9.2A1 1 0 0 0 13.4 10.6A2.9 2.9 0 0 1 13.4 14.8L9.9 18.4A3.2 3.2 0 0 1 5.6 18.4A3.2 3.2 0 0 1 5.6 14.1L6.1 13.7A7.3 7.3 0 0 1 5.7 11.2L4.2 12.7A5.1 5.1 0 0 0 4.2 19.8A5.1 5.1 0 0 0 11.3 19.8L13.1 18A6 6 0 0 1 16.2 13.7Z" /></svg>
						<div>
							<h1>Title</h1>
							<p>Top language</p>
						</div>
					</div>
					<div class="stats-header">
						<svg viewBox="0 0 24 24"><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>
						<div>
							<h1>Title</h1>
							<p>Top country</p>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-6">
					
				</div>
			</div>
		</div>		
	</div>
	
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