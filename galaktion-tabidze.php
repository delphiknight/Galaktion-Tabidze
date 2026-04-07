<?php
/**
 * @package Gala
 * @version 1.0.0
 */
/*
Plugin Name: Galaktion Tabidze
Description: When activated you will randomly see a line from <cite>მთაწმინდის მთვარე</cite> by Galaktion Tabidze in the upper right of your admin screen on every page.
Author: Dimitri Gogelia
Author URI: https://gogelia.ge
Version: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: galaktion-tabidze
Domain Path: /languages
*/

function gala_get_lyric() {
	/** These are the lyrics to მთაწმინდის მთვარე by Galaktion Tabidze */
	$lyrics = "ჯერ არასდროს არ შობილა მთვარე ასე წყნარი!
მდუმარებით შემოსილი შეღამების ქნარი
ქროლვით იწვევს ცისფერ ლანდებს და ხეებში აქსოვს…
ასე ჩუმი, ასე ნაზი ჯერ ცა მე არ მახსოვს!
მთვარე თითქოს ზამბახია შუქთა მკრთალი მძივით
და, მის შუქში გახვეული მსუბუქ სიზმარივით
მოჩანს მტკვარი და მეტეხი თეთრად მოელვარე…
ოჰ! არასდროს არ შობილა ასე ნაზი მთვარე!
აქ ჩემს ახლო აკაკის ლანდს სძინავს მეფურ ძილით
აქ მწუხარე სასაფლაოს, ვარდით და გვირილით
ეფინება ვარსკვლავების კრთომა მხიარული
ბარათაშვილს აქ უყვარდა ობლად სიარული…
და მეც მოვკვდე სიმღერებში ტბის სევდიან გედად
ოღონდ ვთქვა, თუ ღამემ სულში როგორ ჩაიხედა
თუ სიზმარმა ვით შეისხა ციდან ცამდე ფრთები
და გაშალა ოცნებათა ლურჯი იალქნები
თუ სიკვდილის სიახლოვე როგორ ასხვაფერებს
მომაკვდავი გედის ჰანგთა ვარდებს და ჩანჩქერებს
თუ როგორ ვგრძნობ, რომ სულისთვის, ამ ზღვამ რომ აღზარდა
სიკვდილის გზა არ-რა არის, ვარდისფერ გზის გარდა
რომ ამ გზაზე ზღაპარია მგოსანთ სითამამე
რომ არასდროს არ ყოფილა ასე ჩუმი ღამე
რომ, აჩრდილნო, მე თქვენს ახლო სიკვდილს ვეგებები
რომ მეფე ვარ და მგოსანი და სიმღერით ვკვდები
რომ წაჰყვება საუკუნეს თქვენთან ჩემი ქნარი…
ჯერ არასდროს არ შობილა მთვარე ასე წყნარი!";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ];
}

// This just echoes the chosen line, we'll position it later.
function gala_show() {
	$chosen = gala_get_lyric();

	printf(
		'<p id="galaktion"><span class="screen-reader-text">%s </span><span>%s</span></p>',
		esc_html__( 'Line from მთაწმინდის მთვარე by Galaktion Tabidze:', 'galaktion-tabidze' ),
		esc_html( $chosen )
	);
}

// Load plugin translations.
function gala_load_textdomain() {
	load_plugin_textdomain( 'galaktion-tabidze', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'gala_load_textdomain' );

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'gala_show' );

// We need some CSS to position the paragraph.
function gala_css() {
	$css = '
		#galaktion {
			float: right;
			padding: 5px 10px;
			margin: 0;
			font-size: 12px;
			line-height: 1.6666;
			font-style: italic;
			color: #8B6914;
			opacity: 0.85;
		}
		.rtl #galaktion {
			float: left;
		}
		.block-editor-page #galaktion {
			display: none;
		}
		@media screen and (max-width: 782px) {
			#galaktion,
			.rtl #galaktion {
				float: none;
				padding-left: 0;
				padding-right: 0;
			}
		}
	';
	wp_register_style( 'galaktion-tabidze', false, array(), '1.0.0' );
	wp_enqueue_style( 'galaktion-tabidze' );
	wp_add_inline_style( 'galaktion-tabidze', $css );
}

add_action( 'admin_enqueue_scripts', 'gala_css' );
