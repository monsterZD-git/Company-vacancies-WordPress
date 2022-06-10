<?php

/**
 * The settings of the plugin.
 *
 * @link       https://vk.com/id554858695
 * @since      1.0.0
 *
 * @package    wvcl_Plugin
 * @subpackage wvcl_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class wvcl_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	public $tab;
	public $active_tab;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_menu_page(
			'Настройки списка вакансий', 					// The title to be displayed in the browser window for this page.
			'Вакансии',												// The text to be displayed for this menu item
			'manage_options',										// Which type of users can see this menu item
			'wvcl_options',											// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content'),			// The name of the function to call when rendering this menu's page
			'dashicons-groups'
		);

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'input_example'		=>	'default input example',
			'textarea_example'	=>	'',
			'checkbox_example'	=>	'',
			'radio_example'		=>	'2',
			'time_options'		=>	'default'
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content() {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wvcl-wrap wrap">

			<h2><?php esc_html_e( 'Настройки списка вакансий', 'wvcl' ); ?></h2>
			<?php settings_errors(); ?>

			<?php 
				switch ($this->tab) {
					case 'head_hunter':
						$this->active_tab = 'head_hunter';
						break;
					default:
						$this->active_tab = 'head_hunter';
						break;
				}
			?>

			<form method="post" action="options.php">
				<?php
					switch ($this->active_tab) {
						case 'head_hunter':
							settings_fields( 'wvcl_head_hunter' );
							do_settings_sections( 'wvcl_head_hunter' );
							submit_button();
							break;
						default:
							settings_fields( 'wvcl_head_hunter' );
							do_settings_sections( 'wvcl_head_hunter' );
							submit_button();
							break;
					}
				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}

	/**
	 * This function provides a simple description for the Input Examples page.
	 *
	 * It's called from the 'wvcl_theme_initialize_render_form_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function head_hunter_callback() {
		$options = get_option('wvcl_head_hunter');
		echo '
			<p>Скопируйте этот шорткод и вставьте его в свои записи, страницы или содержимое текстового виджета:</p>
			<div class="shortcode">
				<div>[vacancy recruitment="headhunter"]</div>
				<div>
					<span class="dashicons-before dashicons-admin-page" aria-hidden="true"></span>
				</div>
			</div>
			<p>Внимание: неизвестные параметры и параметры с ошибкой в названии игнорируются</p>
		';
	} // end general_options_callback

	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_render_form() {

		if( false == get_option( 'wvcl_description' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wvcl_description', $default_array );
		} // end if

		add_settings_section(
			'description_section',
			__( '', 'wvcl' ),
			array( $this, 'description_callback'),
			'wvcl_description'
		);

		register_setting(
			'wvcl_description',
			'description_section',
			array( $this, 'validate_description')
		);

		if( false == get_option( 'wvcl_head_hunter' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wvcl_head_hunter', $default_array );
		} // end if

		add_settings_section(
			'head_hunter_section',
			__( '', 'wvcl' ),
			array( $this, 'head_hunter_callback'),
			'wvcl_head_hunter'
		);

		add_settings_field(
			'Текстовое поле',
			__( 'Текстовое поле', 'wvcl' ),
			array( $this, 'text_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Область поиска',
			__( 'Область поиска', 'wvcl' ),
			array( $this, 'search_field_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Опыт работы',
			__( 'Опыт работы', 'wvcl' ),
			array( $this, 'experience_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Тип занятости',
			__( 'Тип занятости', 'wvcl' ),
			array( $this, 'employment_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'График работы',
			__( 'График работы', 'wvcl' ),
			array( $this, 'schedule_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Регион',
			__( 'Регион', 'wvcl' ),
			array( $this, 'area_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Ветка или станция метро',
			__( 'Ветка или станция метро', 'wvcl' ),
			array( $this, 'metro_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Профобласть или специализация',
			__( 'Профобласть или специализация', 'wvcl' ),
			array( $this, 'specialization_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Индустрия компании, разместившей вакансию',
			__( 'Индустрия компании, разместившей вакансию', 'wvcl' ),
			array( $this, 'industry_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Идентификатор компании',
			__( 'Идентификатор компании', 'wvcl' ),
			array( $this, 'employer_id_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Код валюты',
			__( 'Код валюты', 'wvcl' ),
			array( $this, 'currency_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Размер заработной платы',
			__( 'Размер заработной платы', 'wvcl' ),
			array( $this, 'salary_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Фильтр по меткам вакансий',
			__( 'Фильтр по меткам вакансий', 'wvcl' ),
			array( $this, 'label_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Показывать вакансии только с указанием зарплаты',
			__( 'Показывать вакансии только с указанием зарплаты', 'wvcl' ),
			array( $this, 'only_with_salary_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Количество дней, в пределах которых нужно найти ваканси',
			__( 'Количество дней, в пределах которых нужно найти ваканси', 'wvcl' ),
			array( $this, 'period_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Дата, которая ограничивает снизу диапазон дат публикации вакансий',
			__( 'Дата, которая ограничивает снизу диапазон дат публикации вакансий', 'wvcl' ),
			array( $this, 'date_from_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Дата, которая ограничивает сверху диапазон дат публикации вакансий',
			__( 'Дата, которая ограничивает сверху диапазон дат публикации вакансий', 'wvcl' ),
			array( $this, 'date_to_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Возвращать ли кластеры для данного поиска',
			__( 'Возвращать ли кластеры для данного поиска', 'wvcl' ),
			array( $this, 'clusters_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Возвращать ли описание использованных параметров поиска',
			__( 'Возвращать ли описание использованных параметров поиска', 'wvcl' ),
			array( $this, 'describe_arguments_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Отключить автоматическое преобразование вакансий',
			__( 'Отключить автоматическое преобразование вакансий', 'wvcl' ),
			array( $this, 'no_magic_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		add_settings_field(
			'Профессиональная роль',
			__( 'Профессиональная роль', 'wvcl' ),
			array( $this, 'professional_role_head_hunter'),
			'wvcl_head_hunter',
			'head_hunter_section'
		);

		register_setting(
			'wvcl_head_hunter',
			'wvcl_head_hunter',
			array( $this, 'validate_field')
		);
	}

	public function text_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="text" name="wvcl_head_hunter[text]" value="' . esc_attr($options['text']) . '" />
		<div class="description" id="tagline-text">
			<p>'.__( 'Доступен язык запросов, как и на основном сайте:', 'wvcl' ).' <a href="https://hh.ru/article/1175" rel="nofollow" target="_blank">https://hh.ru/article/1175</a>. '.__( 'Специально для этого поля есть', 'wvcl' ).' <a href="https://github.com/hhru/api/blob/master/docs/suggests.md#vacancy-search-keyword" rel="nofollow" target="_blank">'.__( 'автодополнение', 'wvcl' ).'</a>.</p>
		</div>';

	} // end text_head_hunter

	public function search_field_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="search_field" name="wvcl_head_hunter[search_field]" value="' . esc_attr($options['search_field']) . '" />
		<div class="description" id="tagline-search_field">
			<p>'.__( 'Справочник с возможными значениями: <code>Область поиска в вакансии</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
			<p>'.__( 'По умолчанию, используются все поля.', 'wvcl' ).'</p>
			<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
		</div>';

	} // end search_field_head_hunter

	public function experience_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
		<input type="text" id="experience" name="wvcl_head_hunter[experience]" value="' . esc_attr($options['experience']) . '" />
		<div class="description" id="tagline-experience">
			<p>'.__( 'Необходимо передавать <code>id</code> из справочника <code>Опыт работы</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
		</div>';

	} // end experience_head_hunter

	public function employment_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="employment" name="wvcl_head_hunter[employment]" value="' . esc_attr($options['employment']) . '" />
			<div class="description" id="tagline-schedule">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника <code>Тип занятости</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end employment_head_hunter

	public function schedule_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="schedule" name="wvcl_head_hunter[schedule]" value="' . esc_attr($options['schedule']) . '" />
			<div class="description" id="tagline-schedule">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника <code>График работы</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end schedule_head_hunter

	public function area_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="area" name="wvcl_head_hunter[area]" value="' . esc_attr($options['area']) . '" />
			<div class="description" id="tagline-area">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника', 'wvcl' ).' <a href="https://application-interface.com/wvcl/areas/" rel="nofollow" target="_blank">/areas</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end area_head_hunter

	public function metro_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="metro" name="wvcl_head_hunter[metro]" value="' . esc_attr($options['metro']) . '" />
			<div class="description" id="tagline-metro">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника', 'wvcl' ).' <a href="https://application-interface.com/wvcl/metro/" rel="nofollow" target="_blank">/metro</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end metro_head_hunter
	
	public function specialization_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="specialization" name="wvcl_head_hunter[specialization]" value="' . esc_attr($options['specialization']) . '" />
			<div class="description" id="tagline-specialization">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника', 'wvcl' ).' <a href="https://application-interface.com/wvcl/specializations/" rel="nofollow" target="_blank">/specializations</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end specialization_head_hunter

	public function industry_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="industry" name="wvcl_head_hunter[industry]" value="' . esc_attr($options['industry']) . '" />
			<div class="description" id="tagline-industry">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника', 'wvcl' ).' <a href="https://application-interface.com/wvcl/industries/" rel="nofollow" target="_blank">/industries</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';
			
	} // end industry_head_hunter
	
	public function employer_id_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="employer_id" name="wvcl_head_hunter[employer_id]" value="' . esc_attr($options['employer_id']) . '" />
			<div class="description" id="tagline-employer_id">
				<p>'.__( 'Идентификатор', 'wvcl' ).' <a href="https://github.com/hhru/api/blob/master/docs/employers.md" rel="nofollow" target="_blank">'.__( 'компании', 'wvcl' ).'</a></p>
				<p>'.__( 'Идентификатор компании так же можно посмотреть в адресной строке, например https://hh.ru/employer/<code>1455</code>', 'wvcl' ).'</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';

	} // end employer_id_head_hunter

	public function currency_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="currency" name="wvcl_head_hunter[currency]" value="' . esc_attr($options['currency']) . '" />
			<div class="description" id="tagline-currency">
				<p>'.__( 'Справочник с возможными значениями: <code>Код валюты</code> (ключ <code>code</code>) в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Имеет смысл указывать только совместно с параметром <code>Размер заработной платы</code>.', 'wvcl' ).'</p>
			</div>';

	} // end currency_head_hunter
	
	public function salary_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="salary" name="wvcl_head_hunter[salary]" value="' . esc_attr($options['salary']) . '" />
			<div class="description" id="tagline-salary">
				<p>'.__( 'Если указано это поле, но не указано <code>Код валюты</code>, то используется значение <code>RUB</code> у <code>Код валюты</code>.', 'wvcl' ).'</p>
				<p>'.__( 'При указании значения будут найдены вакансии, в которых вилка зарплаты близка к указанной в запросе.', 'wvcl' ).'</p>
				<p>'.__( 'При этом значения пересчитываются по текущим курсам ЦБ РФ.', 'wvcl' ).'</p>
				<p>'.__( 'Например, при указании <code>Размер заработной платы = 100 и Код валюты = EUR</code> будут найдены вакансии, где вилка зарплаты указана в рублях и после пересчёта в Евро близка к 100 EUR.', 'wvcl' ).'</p>
				<p>'.__( 'По умолчанию будут также найдены вакансии, в которых вилка зарплаты не указана, чтобы такие вакансии отфильтровать, используйте <code>Показывать вакансии только с указанием зарплаты = да</code>.', 'wvcl' ).'</p>
			</div>';

	} // end salary_head_hunter

	public function label_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="label" name="wvcl_head_hunter[label]" value="' . esc_attr($options['label']) . '" />
			<div class="description" id="tagline-label">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника <code>Метки вакансии</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
			</div>';
			
	} // end label_head_hunter

	public function only_with_salary_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="only_with_salary" name="wvcl_head_hunter[only_with_salary]">
				<option value="false" ' . selected( esc_attr($options['only_with_salary']), 'false', false) . '>'. __( 'Нет', 'wvcl' ) . '</option>
				<option value="true"' . selected( esc_attr($options['only_with_salary']), 'true', false) . '>' . __( 'Да', 'wvcl' ) . '</option>
			</select>
			<div class="description" id="tagline-only_with_salary">
				<p>'.__( 'Возможные значения: <code>Да</code> или <code>Нет</code>.', 'wvcl' ).'</p>
				<p>'.__( 'По умолчанию, используется <code>Нет</code>.', 'wvcl' ).'</p>
			</div>';

	} // end only_with_salary_head_hunter

	public function period_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="period" name="wvcl_head_hunter[period]" value="' . esc_attr($options['period']) . '" />
			<div class="description" id="tagline-period">
				<p>'.__( 'Максимальное значение:', 'wvcl' ).' <code>30</code>.</p>
			</div>';
			
	} // end period_head_hunter

	public function date_from_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="date_from" name="wvcl_head_hunter[date_from]" value="' . esc_attr($options['date_from']) . '" placeholder="___-__-__" />
			<div class="description" id="tagline-date_from">
				<p>'.__( 'Нельзя передавать вместе с параметром <code>Количество дней, в пределах которых нужно найти ваканси</code>.', 'wvcl' ).'</p>
				<p>'.__( 'Значение указывается в формате', 'wvcl' ).' <a href="https://github.com/hhru/api/blob/master/docs/general.md#date-format" rel="nofollow" target="_blank">ISO 8601</a> - <code>YYYY-MM-DD</code> '.__( 'или с точность до секунды', 'wvcl' ).' <code>YYYY-MM-DDThh:mm:ss±hhmm</code>.</p>
				<p>'.__( 'Указанное значение будет округлено до ближайших 5 минут.', 'wvcl' ).'</p>
			</div>';

	} // end date_from_head_hunter

	public function date_to_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="date_to" name="wvcl_head_hunter[date_to]" value="' . esc_attr($options['date_to']) . '" placeholder="___-__-__" />
			<div class="description" id="tagline-date_to">
				<p>'.__( 'Необходимо передавать только в паре с параметром <code>Дата, которая ограничивает снизу диапазон дат публикации вакансий</code>.', 'wvcl' ).'</p>
				<p>'.__( 'Нельзя передавать вместе с параметром <code>Количество дней, в пределах которых нужно найти ваканси</code>.', 'wvcl' ).'</p>
				<p>'.__( 'Значение указывается в формате', 'wvcl' ).' <a href="https://github.com/hhru/api/blob/master/docs/general.md#date-format" rel="nofollow" target="_blank">ISO 8601</a> - <code>YYYY-MM-DD</code> '.__( 'или с точность до секунды', 'wvcl' ).' <code>YYYY-MM-DDThh:mm:ss±hhmm</code>.</p>
				<p>'.__( 'Указанное значение будет округлено до ближайших 5 минут.', 'wvcl' ).'</p>
			</div>';
			
	} // end date_to_head_hunter

	public function order_by_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="order_by" name="wvcl_head_hunter[order_by]" value="' . esc_attr($options['order_by']) . '" />
			<div class="description" id="tagline-order_by">
				<p>'.__( 'Справочник с возможными значениями: <code>vacancy_search_order</code> в', 'wvcl' ).' <a href="https://application-interface.com/wvcl/dictionaries/" rel="nofollow" target="_blank">/dictionaries</a>.</p>
				<p>'.__( 'Если выбрана сортировка по удалённости от гео-точки <code>distance</code>, необходимо также задать её координаты', 'wvcl' ).' <code>sort_point_lat</code>,<code>sort_point_lng</code>.</p>
			</div>';
			
	} // end order_by_head_hunter

	public function clusters_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="clusters" name="wvcl_head_hunter[clusters]">
				<option value="false" ' . selected( esc_attr($options['clusters']), 'false', false) . '>'. __( 'Нет', 'wvcl' ) . '</option>
				<option value="true"' . selected( esc_attr($options['clusters']), 'true', false) . '>' . __( 'Да', 'wvcl' ) . '</option>
			</select>
			<div class="description" id="tagline-clusters">
				<p><a href="https://github.com/hhru/api/blob/master/docs/clusters.md" rel="nofollow" target="_blank">'.__( 'Кластеры для данного поиска', 'wvcl' ).'</a>, '.__( 'по умолчанию: <code>Нет</code>.', 'wvcl' ).'</p>
			</div>';
			
	} // end clusters_head_hunter

	public function describe_arguments_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="describe_arguments" name="wvcl_head_hunter[describe_arguments]">
				<option value="false" ' . selected( esc_attr($options['describe_arguments']), 'false', false) . '>'. __( 'Нет', 'wvcl' ) . '</option>
				<option value="true"' . selected( esc_attr($options['describe_arguments']), 'true', false) . '>' . __( 'Да', 'wvcl' ) . '</option>
			</select>
			<div class="description" id="tagline-describe_arguments">
				<p><a href="https://github.com/hhru/api/blob/master/docs/vacancies_search_arguments.md" rel="nofollow" target="_blank">'.__( 'Описание использованных параметров поиска', 'wvcl' ).'</a>, '.__( 'по умолчанию: <code>Нет</code>.', 'wvcl' ).'</p>
			</div>';
			
	} // end describe_arguments_head_hunter

	public function no_magic_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<select id="no_magic" name="wvcl_head_hunter[no_magic]">
				<option value="false" ' . selected( esc_attr($options['no_magic']), 'false', false) . '>'. __( 'Нет', 'wvcl' ) . '</option>
				<option value="true"' . selected( esc_attr($options['no_magic']), 'true', false) . '>' . __( 'Да', 'wvcl' ) . '</option>
			</select>
			<div class="description" id="tagline-no_magic">
				<p>'.__( 'Если значение <code>Да</code> – отключить автоматическое преобразование вакансий.', 'wvcl' ).'</p>
				<p>'.__( 'По умолчанию – <code>Нет</code>. При включённом автоматическом преобразовании, будет предпринята попытка изменить текстовый запрос пользователя на набор параметров.', 'wvcl' ).'</p> 
				<p>'.__( 'Например, запрос <code>Текстовое поле = москва бухгалтер 100500</code> будет преобразован в <code>Текстовое поле = бухгалтер и Показывать вакансии только с указанием зарплаты = Да и Регион = Москва и Размер заработной платы = 100500</code>.', 'wvcl' ).'</p>
			</div>';
			
	} // end no_magic_head_hunter

	public function professional_role_head_hunter() {

		$options = get_option( 'wvcl_head_hunter' );

		// Render the output
		echo '
			<input type="text" id="professional_role" name="wvcl_head_hunter[professional_role]" value="' . esc_attr($options['professional_role']) . '" />
			<div class="description" id="tagline-professional_role">
				<p>'.__( 'Необходимо передавать <code>id</code> из справочника', 'wvcl' ).' <a href="https://api.hh.ru/openapi/redoc#tag/Spravochniki/paths/~1professional_roles/get" rel="nofollow" target="_blank">/professional_roles</a>.</p>
				<p>'.__( 'Возможно указание нескольких значений.', 'wvcl' ).'</p>
				<p>'.__( 'Замена специализациям (параметр <code>Профобласть или специализация</code>).', 'wvcl' ).'</p>
			</div>';

	} // end professional_role_head_hunter	

	public function validate_field( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_field', $output, $input );

	} // end validate_field

}