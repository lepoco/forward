/*!
  * Forward 2.0.0 (https://github.com/rapiddev/Forward)
  * Copyright 2018-2020 RapidDev
  * Licensed under MIT (https://github.com/rapiddev/Forward/blob/master/LICENSE)
  */

	//Custom forEach for Array
	Array.prototype.forEach||(Array.prototype.forEach=function(r){let t=this.length;if("function"!=typeof r)throw new TypeError;for(let o=arguments[1],h=0;h<t;h++)h in this&&r.call(o,this[h],h,this)});

	//JSON Verify
	function jsonParse(string)
	{
		if(/^[\],:{}\s]*$/.test(string.replace(/\\["\\\/bfnrtu]/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//Fancy logging
	function console_log(message, color="#fff"){console.log("%cForward: "+"%c"+message, "color:#dc3545;font-weight: bold;", "color: "+color);}
	console.log("==============================\nForward \nversion: " + forward.version + "\nCopyright © 2019-2020 RapidDev\nhttps://rdev.cc/\n==============================");

	//Translator
	function __T(text)
	{
		if(typeof translator == 'undefined')
		{
			return text;
		}
		else
		{
			if(translator.length == 0)
			{
				return text;
			}
			else
			{
				if( text in translator )
				{
					return translator[ text ];
				}
				else
				{
					return text;
				}
			}
		}
	}

	//On DOM loaded, veryfiy and run
	document.addEventListener('DOMContentLoaded', function()
	{
		if(forward.usernonce != jQuery('head').attr('user-nonce'))
		{
			console.log(forward);
			if(forward.page == 'install')
			{
				themeFunctions();
			}

			throw new Error('User nonce compliance not detected.!');
		}

		console_log( 'JavaScript loaded successfully' );
		console_log( 'Base url: ' + forward.baseurl  );
		if(forward.pagenow != 'home')
			console_log( 'Ajax gate: ' + forward.ajax  );
		console_log( 'Page now: ' + forward.pagenow  );
		console_log( 'Nonce: ' + forward.usernonce  );

		themeFunctions();
	});

	function PlatformTranslator( name )
	{
		switch( name )
		{
			case 'windows':
				return 'Windows (?)';
			case 'windows_10':
				return 'Windows 10';
			case 'android':
				return 'Android';
			default:
				return name;
		}
	}

	function AgentTranslator( name )
	{
		switch( name )
		{
			case 'chrome':
				return 'Google Chrome';
			case 'edge':
				return 'MS Edge';
			case 'internet_explorer':
				return 'MS Internet Explorer';
			default:
				return name;
		}
	}

	function themeFunctions()
	{
		jQuery("#show_hide_password a").on('click', function(event) {
			event.preventDefault();
			if(jQuery('#show_hide_password input').attr("type") == "text"){
				jQuery('#show_hide_password input').attr('type', 'password');
			}else if(jQuery('#show_hide_password input').attr("type") == "password"){
				jQuery('#show_hide_password input').attr('type', 'text');
			}
		});

		console_log( 'The main functions of the theme have loaded correctly.' );

		if(forward.pagenow == 'install')
		{
			PageInstall();
		}
		else if(forward.pagenow == 'dashboard')
		{
			PageDashboard();
		}
		else if(forward.pagenow == 'login')
		{
			PageLogin();
		}
		else
		{
			console_log( 'This page has no special functions.' );
		}
	}

	function PageInstall()
	{
		console_log( 'The functions for page Install have been loaded.' );
		jQuery("#input_user_password").on("change paste keyup",function()
		{
			let e=jQuery(this).val(),s=zxcvbn(e);""!==e?jQuery(".def_password--strength").html("Strength: <strong>"+{0:"Worst ☹",1:"Bad ☹",2:"Weak ☹",3:"Good 🙃",4:"Strong 🙂"}[s.score]+"</strong><br/><span class='feedback'>"+s.feedback.warning+" "+s.feedback.suggestions+"</span"):jQuery(".def_password--strength").html("")
		});

		jQuery('#install-forward').on('click', function(e)
		{
			e.preventDefault();

			jQuery('#install-forward').attr('disabled', 'disabled');
			jQuery('#install-form > div, #install-forward, #install-form-alert').fadeOut(200);
			jQuery('#install-form').slideUp(400, function()
			{
				jQuery('#install-progress').slideDown(400);
			});

			jQuery.ajax({
				url: forward.baseurl,
				type: 'post',
				data: {
					action: 'setup',
					input_scriptname: jQuery('#input_scriptname').val(),
					input_baseuri: jQuery('#input_baseuri').val(),
					input_db_name: jQuery('#input_db_name').val(),
					input_db_user: jQuery('#input_db_user').val(),
					input_db_host: jQuery('#input_db_host').val(),
					input_db_password: jQuery('#input_db_password').val(),
					input_user_name: jQuery('#input_user_name').val(),
					input_user_password: jQuery('#input_user_password').val(),
				},
				success:function(e)
				{
					console.log(e);
					if(jsonParse(e) && e != null)
					{
						let result = JSON.parse(e);

						if(result.status == 'error')
						{
							window.setTimeout(function()
							{
								jQuery('#install-form, #install-form-alert').hide();
								jQuery('#install-form > div, #install-forward, #install-progress').show();

								jQuery('#install-form-alert > span').html(result.message);

								jQuery('#install-progress').slideUp(400, function()
								{
									jQuery('#install-forward').removeAttr('disabled');
									jQuery('#install-form').slideDown(400, function(e)
									{
										jQuery('#install-form-alert').slideDown(400);
									});
								});
							}, 1500);


						}
						else if(result.status == 'success')
						{
							window.setTimeout(function()
							{
								jQuery('#install-progress').fadeOut(400, function()
								{
									jQuery('#install-done').fadeIn(400);
									window.setTimeout(function(){
										window.location.href = jQuery('#input_baseuri').val()+'dashboard';
									}, 3000);
								});
							}, 1000);
						}
					}
					else
					{
						console.log('error');
					}
				},
				fail: function(xhr, textStatus, errorThrown){
					jQuery('#install-progress').slideUp(400);
					console.log(xhr);
					console.log(textStatus);
					alert(errorThrown);
				}
			});
		});
	}

	function PageDashboard()
	{
		console_log( 'The functions for page Dashboard have been loaded.' );

		//Adjust dashboard height
		if( jQuery('html').height() > 992 )
		{
			jQuery('body').css('display', 'initial');
			jQuery('#rdev-dashboard').css( 'height', jQuery('#forward').outerHeight() - jQuery('.navbar').outerHeight() + 'px' );
		}

		//Ctrl click
		let ctrl_click = false;
		jQuery( document ).keydown( function( event )
		{
			//17 ctrl
			//18 alt
			//16 shift
			if( event.which == 17 )
				ctrl_click = true;
		} );

		jQuery( document ).keyup( function()
		{
			ctrl_click = false;
		} );

		/** Copy to clipboard **/
		jQuery('.shorted-url').on('click', function(e){e.preventDefault();});
		jQuery('.links-card').on('click', function(e){
			e.preventDefault();

			if( jQuery(this).data()['id'] in records )
			{
				console.log(records);
				FillRecordData( records[ jQuery(this).data()['id'] ] );
			}
			

			if(ctrl_click)
			{
				console_log('Links card pressed with ctrl button.');
				//clipboard_alert();
			}

		});

		function clipboard_alert(){
			if(jQuery('#links-copied').is(':hidden'))
			{
				jQuery('#links-copied').slideToggle();
				window.setTimeout(function(){
					jQuery('#links-copied').slideToggle(400, function(){jQuery('#links-copied').hide();});
				}, 3000);
			}
		}
		let clipboard_link = new ClipboardJS('.shorted-url');
		let clipboard_card = new ClipboardJS('.links-card');
		clipboard_link.on('success', function(e){clipboard_alert();});
		clipboard_card.on('success', function(e){clipboard_alert();});

		function AjaxRecordData( rid, ondone )
		{
			let record_id = rid;

			jQuery.ajax({
				url: forward.ajax,
				type:'post',
				data: {
					action: 'get_record_data',
					nonce: forward.getrecord,
					input_record_id: record_id
				},
				success: function( e )
				{
					if( jsonParse( e ) )
					{
						let result = JSON.parse(e);
						ondone( result );
					}
				},
				fail:function(xhr, textStatus, errorThrown)
				{
					console.log(xhr);
					console.log(textStatus);
					console.log(errorThrown);
				}
			});
		}

		function FillCharts( bn, bv, pn, pv )
		{
			let letterbox = [
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'
			];

			console.log(bn);
			console.log(bv);
			console.log(pn);
			console.log(pv);

			//Browsers labels
			jQuery('.pie-browsers-labels').empty();
			for (var i = 0; i < bn.length; i++)
			{
				jQuery('.pie-browsers-labels').append('<li class="pie-browsers-label-' + letterbox[i] + '">' + bn[i] + '</li>');
			}

			//Browsers pie
			let browsers_chart = new Chartist.Pie('.pie-browsers', {
				series: bv
			}, {
				donut: true,
				showLabel: false
			});
			browsers_chart.on('created', function(bar) {
				jQuery('.pie-browsers .ct-series').on('mouseover', function()
				{
					let current_series = ( jQuery(this).attr('class').split(' ')[1] ).substr(10);
					jQuery(this).addClass('ct-hover');
					jQuery('.pie-browsers-label-' + current_series).addClass('li-hover');
				});
				jQuery('.pie-browsers .ct-series').on('mouseout', function()
				{
					jQuery('.pie-browsers .ct-series').removeClass('ct-hover');
					jQuery('.pie-browsers-labels > li').removeClass('li-hover');
				});
			});
			browsers_chart.on('draw', function(data) {
				if(data.type === 'slice') {
					let pathLength = data.element._node.getTotalLength();
					data.element.attr({
						'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
					});
					let animationDefinition = {
						'stroke-dashoffset': {
							id: 'anim' + data.index,
							dur: 500,
							from: -pathLength + 'px',
							to:  '0px',
							easing: Chartist.Svg.Easing.easeOutQuint,
						fill: 'freeze'
					}
				};
				if(data.index !== 0) {
					animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
				}
				data.element.attr({
					'stroke-dashoffset': -pathLength + 'px'
				});
				data.element.animate(animationDefinition, false);
				}
			});

			//Platforms labels
			jQuery('.pie-platforms-labels').empty();
			for (var i = 0; i < pn.length; i++)
			{
				jQuery('.pie-platforms-labels').append('<li class="pie-platforms-label-' + letterbox[i] + '">' + pn[i] + '</li>');
			}
			//Platforms pie
			let platforms_chart = new Chartist.Pie('.pie-platforms', {
				series: pv
			}, {
				donut: true,
				showLabel: false
			});
			platforms_chart.on('created', function( bar ) {
				jQuery('.pie-platforms .ct-series').on('mouseover', function()
				{
					let current_series = ( jQuery(this).attr('class').split(' ')[1] ).substr(10);
					jQuery(this).addClass('ct-hover');
					jQuery('.pie-platforms-label-' + current_series).addClass('li-hover');
				});
				jQuery('.pie-platforms .ct-series').on('mouseout', function()
				{
					jQuery('.pie-platforms .ct-series').removeClass('ct-hover');
					jQuery('.pie-platforms-labels > li').removeClass('li-hover');
				});
			});
			platforms_chart.on('draw', function(data) {
				if(data.type === 'slice') {
					let pathLength = data.element._node.getTotalLength();
					data.element.attr({
						'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
					});
					let animationDefinition = {
						'stroke-dashoffset': {
							id: 'anim' + data.index,
							dur: 500,
							from: -pathLength + 'px',
							to:  '0px',
							easing: Chartist.Svg.Easing.easeOutQuint,
						fill: 'freeze'
					}
				};
				if(data.index !== 0) {
					animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
				}
				data.element.attr({
					'stroke-dashoffset': -pathLength + 'px'
				});
				data.element.animate(animationDefinition, false);
				}
			});
		}

		function FillRecordData( record )
		{
			console.log(record);

			let date = new Date( record[6] );
			date = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

			jQuery( '#preview-record-date' ).html( date );
			jQuery( '#preview-record-slug' ).html( '/' + record[3] );
			jQuery( '#preview-record-url' ).html( record[4] );
			jQuery( '#preview-record-url' ).attr( 'href',  record[4] );
			jQuery( '#preview-record-user' ).attr( 'href',  forward.baseurl + 'users/' + record[1] );
			jQuery( '#preview-record-user' ).html( record[1] );


			AjaxRecordData( record[0], function(e)
			{
				let agents_keys = Object.keys( e.agents );
				let agents_names = [];
				let agents_values = [];
				for (var i = 0; i < agents_keys.length; i++)
				{
					agents_names.push( AgentTranslator( visitor_data.agents[ agents_keys[i] ] ) );
					agents_values.push( e.agents[ agents_keys[i] ] );
				}

				let platforms_keys = Object.keys( e.platforms );
				let platforms_names = [];
				let platforms_values = [];
				for (var i = 0; i < platforms_keys.length; i++)
				{
					platforms_names.push( PlatformTranslator( visitor_data.platforms[ platforms_keys[i] ] ) );
					platforms_values.push( e.platforms[ platforms_keys[i] ] );
				}

				FillCharts( agents_names, agents_values, platforms_names, platforms_values);
			} );
		}

		jQuery(function()
		{
			function AjaxAddRecord()
			{
				if(jQuery('#add-alert').is(':visible')){jQuery('#add-alert').slideToggle(400,function(){jQuery('#add-alert').hide();});}
				if(jQuery('#add-success').is(':visible')){jQuery('#add-success').slideToggle(400,function(){jQuery('#add-success').hide();});}
				
				jQuery.ajax({
					url: forward.ajax,
					type:'post',
					data:jQuery("#add-record-form").serialize(),
					success:function(e)
					{
						if(e == 's01')
						{
							jQuery('#add-success').slideToggle();

							jQuery('#total_records_count').html(parseInt(jQuery('#total_records_count').html()) + 1);


							let slug = jQuery('#input-record-slug').val();
							if(slug == '')
							{
								slug = jQuery('#input-rand-value').val();
							}
							let url = forward.baseurl + slug;
							let target = jQuery('#input-record-url').val();
							let target_shorted = jQuery('#input-record-url').val();
							let date = new Date();
							date = date.getFullYear() + '-' + ('0' + (date.getMonth()+1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);;

							jQuery("#records_list div:nth-child(2)").after('<div class="card links-card" data-clipboard-text="'+url+'"><div class="card-body"><div><small>'+date+'</small><h2><a target="_blank" rel="noopener" href="'+url+'">/'+slug+'</a></h2><p><a target="_blank" rel="noopener" href="'+target_shorted+'">'+target+'...</a></p></div><span>0</span></div></div>');;

							window.setTimeout(function(){
								jQuery('#add-success').slideToggle(400, function(){jQuery('#add-success').hide();});
							}, 3000);
						}
						else
						{
							
							let error_text = __T('e1');

							if(e == 'e07')
							{
								error_text = __T('e7');
							}
							else if(e == 'e08')
							{
								error_text = __T('e8');
							}
							else if(e == 'e10')
							{
								error_text = __T('e10');
							}

							jQuery('#error_text').html(error_text);
							jQuery('#add-alert').slideToggle();
						}
						console.log(e);
					},
					fail:function(xhr, textStatus, errorThrown){
						console.log(xhr);
						console.log(textStatus);
						console.log(errorThrown);
						jQuery('#add-alert').slideToggle();
					}
				});
			}
			jQuery('#add-record-form').on('submit', function(e){
				e.preventDefault();
				AjaxAddRecord();
			});
			jQuery('#add-record-send').on('click', function(e) {
				e.preventDefault();
				AjaxAddRecord();
			});
		});

		if( Object.keys( records ).length > 0 )
		{
			FillRecordData( records[ Object.keys( records ).length ] );
		}
	}

	function PageLogin()
	{
		console_log( 'The functions for page Login have been loaded.' );

		jQuery("#passsword").on("change paste keyup",function()
		{
			let e=jQuery(this).val(),s=zxcvbn(e);""!==e?jQuery(".def_password--strength").html("Strength: <strong>"+{0:"Worst ☹",1:"Bad ☹",2:"Weak ☹",3:"Good 🙃",4:"Strong 🙂"}[s.score]+"</strong><br/><span class='feedback'>"+s.feedback.warning+" "+s.feedback.suggestions+"</span"):jQuery(".def_password--strength").html("")
		});

		jQuery('#button-form').on('click', function(e){
			e.preventDefault();
			LoginQuery();
		});

		jQuery('#login-form').on('submit', function(e){
			e.preventDefault();
			LoginQuery();
		});

		function LoginQuery()
		{
			if(jQuery('#login-alert').is(':visible'))
			{
				jQuery('#login-alert').slideToggle();
			}

			jQuery.ajax({
				url: forward.ajax,
				type: 'post',
				data: jQuery("#login-form").serialize(),
				success: function(e)
				{
					console.log(e);

					if(e == 's01')
					{
						location.reload();
					}
					else
					{
						jQuery('#login-alert').slideToggle();
					}
				},
				fail:function(xhr, textStatus, errorThrown){
					jQuery('#login-alert').slideToggle();
				}
			});
		}
	}