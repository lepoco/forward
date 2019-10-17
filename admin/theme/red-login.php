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

<div id="login-bg">
	<picture>
		<source srcset="<?php echo $this->home_url(); ?>admin/img/bg.webp" type="image/webp">
		<source srcset="<?php echo $this->home_url(); ?>admin/img/bg.jpeg" type="image/jpeg">
		<img alt="This is my face" src="<?php echo $this->home_url(); ?>admin/img/bg.jpeg">
	</picture>
</div>
<section id="red-login">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-6">
				<img src="#" alt="logo">
			</div>
			<div class="col-12 col-lg-6">
				<div id="login-card">
					<form>
						<div class="card">
							<div class="card-body">
								<h1>Sign in</h1>
								
								  <div class="form-group">
								    <label for="exampleInputEmail1">Email address</label>
								    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
								  </div>
								  <div class="form-group">
								    <label for="exampleInputPassword1">Password</label>
								    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
								  </div>
								
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->footer(); ?>