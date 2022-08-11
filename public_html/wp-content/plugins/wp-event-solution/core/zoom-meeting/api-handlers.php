<?php
namespace Etn\Core\Zoom_Meeting;

use DateTime;
use Etn\Traits\Singleton;
use Etn\Utils\Helper;

defined('ABSPATH') || exit;

class Api_Handlers{

    use Singleton;

    /**
     * Get zoom meeting user list
     */
    public function zoom_meeting_user_list(){
        $users = array();
        $get_expiry_time = get_option( 'zoom_user_list_expiry_time' );
        if ( $get_expiry_time && time() > $get_expiry_time ) {
            update_option( 'zoom_user_list' , '' );
        }
        $check_transient = get_option( 'zoom_user_list' );
        if ( $check_transient ) {
            $users = $check_transient;
        } else {
            $get_users    = \Etn\Core\Zoom_Meeting\Api::instance()->user_list();
            $decode_users = json_decode( $get_users );
            if ( empty($decode_users) || ! empty( $decode_users->code ) ) {
                $users = false;
            }else{
                $users = $decode_users->users;
                update_option( 'zoom_user_list', $users );
                update_option( 'zoom_user_list_expiry_time', time() + 108000 );
            }
        }
        $user_arr = [];
        if ($users && count( $users )>0) {
            if ($users) {
               foreach ($users as $key => $value) {
                  $user_arr[ $value->id ] = $value->first_name . " " . $value->last_name;
               }
            }
        }
        return $user_arr;
	}

	/**
	 * api connection check function
	 *
	 */
	public function zoom_api_conn_check(){
		return \Etn\Core\Zoom_Meeting\Api::instance()->user_list();
	}

	/**
	 * create meeting function
	 *
	 */
	public function create_meeting( $request_data )
	{
		return \Etn\Core\Zoom_Meeting\Api::instance()->create_meeting( $request_data );
	}

    /**
     * Remove cache function
     */
    public function remove_cache(){
        update_option( 'zoom_user_list', '' );
        update_option( 'zoom_user_list_expiry_time', '' );
	}
	
    /**
     * Get time zone function
     *
     */
	public function get_timezone() {
		$zones_array = array(
			"Pacific/Midway"                 => "(GMT-11:00) Midway Island, Samoa ",
			"Pacific/Pago_Pago"              => "(GMT-11:00) Pago Pago ",
			"Pacific/Honolulu"               => "(GMT-10:00) Hawaii ",
			"America/Anchorage"              => "(GMT-8:00) Alaska ",
			"America/Vancouver"              => "(GMT-7:00) Vancouver ",
			"America/Los_Angeles"            => "(GMT-7:00) Pacific Time (US and Canada) ",
			"America/Tijuana"                => "(GMT-7:00) Tijuana ",
			"America/Phoenix"                => "(GMT-7:00) Arizona ",
			"America/Edmonton"               => "(GMT-6:00) Edmonton ",
			"America/Denver"                 => "(GMT-6:00) Mountain Time (US and Canada) ",
			"America/Mazatlan"               => "(GMT-6:00) Mazatlan ",
			"America/Regina"                 => "(GMT-6:00) Saskatchewan ",
			"America/Guatemala"              => "(GMT-6:00) Guatemala ",
			"America/El_Salvador"            => "(GMT-6:00) El Salvador ",
			"America/Managua"                => "(GMT-6:00) Managua ",
			"America/Costa_Rica"             => "(GMT-6:00) Costa Rica ",
			"America/Tegucigalpa"            => "(GMT-6:00) Tegucigalpa ",
			"America/Winnipeg"               => "(GMT-5:00) Winnipeg ",
			"America/Chicago"                => "(GMT-5:00) Central Time (US and Canada) ",
			"America/Mexico_City"            => "(GMT-5:00) Mexico City ",
			"America/Panama"                 => "(GMT-5:00) Panama ",
			"America/Bogota"                 => "(GMT-5:00) Bogota ",
			"America/Lima"                   => "(GMT-5:00) Lima ",
			"America/Caracas"                => "(GMT-4:30) Caracas ",
			"America/Montreal"               => "(GMT-4:00) Montreal ",
			"America/New_York"               => "(GMT-4:00) Eastern Time (US and Canada) ",
			"America/Indianapolis"           => "(GMT-4:00) Indiana (East) ",
			"America/Puerto_Rico"            => "(GMT-4:00) Puerto Rico ",
			"America/Santiago"               => "(GMT-4:00) Santiago ",
			"America/Halifax"                => "(GMT-3:00) Halifax ",
			"America/Montevideo"             => "(GMT-3:00) Montevideo ",
			"America/Araguaina"              => "(GMT-3:00) Brasilia ",
			"America/Argentina/Buenos_Aires" => "(GMT-3:00) Buenos Aires, Georgetown ",
			"America/Sao_Paulo"              => "(GMT-3:00) Sao Paulo ",
			"Canada/Atlantic"                => "(GMT-3:00) Atlantic Time (Canada) ",
			"America/St_Johns"               => "(GMT-2:30) Newfoundland and Labrador ",
			"America/Godthab"                => "(GMT-2:00) Greenland ",
			"Atlantic/Cape_Verde"            => "(GMT-1:00) Cape Verde Islands ",
			"Atlantic/Azores"                => "(GMT+0:00) Azores ",
			"UTC"                            => "(GMT+0:00) Universal Time UTC ",
			"Etc/Greenwich"                  => "(GMT+0:00) Greenwich Mean Time ",
			"Atlantic/Reykjavik"             => "(GMT+0:00) Reykjavik ",
			"Africa/Nouakchott"              => "(GMT+0:00) Nouakchott ",
			"Europe/Dublin"                  => "(GMT+1:00) Dublin ",
			"Europe/London"                  => "(GMT+1:00) London ",
			"Europe/Lisbon"                  => "(GMT+1:00) Lisbon ",
			"Africa/Casablanca"              => "(GMT+1:00) Casablanca ",
			"Africa/Bangui"                  => "(GMT+1:00) West Central Africa ",
			"Africa/Algiers"                 => "(GMT+1:00) Algiers ",
			"Africa/Tunis"                   => "(GMT+1:00) Tunis ",
			"Europe/Belgrade"                => "(GMT+2:00) Belgrade, Bratislava, Ljubljana ",
			"CET"                            => "(GMT+2:00) Sarajevo, Skopje, Zagreb ",
			"Europe/Oslo"                    => "(GMT+2:00) Oslo ",
			"Europe/Copenhagen"              => "(GMT+2:00) Copenhagen ",
			"Europe/Brussels"                => "(GMT+2:00) Brussels ",
			"Europe/Berlin"                  => "(GMT+2:00) Amsterdam, Berlin, Rome, Stockholm, Vienna ",
			"Europe/Amsterdam"               => "(GMT+2:00) Amsterdam ",
			"Europe/Rome"                    => "(GMT+2:00) Rome ",
			"Europe/Stockholm"               => "(GMT+2:00) Stockholm ",
			"Europe/Vienna"                  => "(GMT+2:00) Vienna ",
			"Europe/Luxembourg"              => "(GMT+2:00) Luxembourg ",
			"Europe/Paris"                   => "(GMT+2:00) Paris ",
			"Europe/Zurich"                  => "(GMT+2:00) Zurich ",
			"Europe/Madrid"                  => "(GMT+2:00) Madrid ",
			"Africa/Harare"                  => "(GMT+2:00) Harare, Pretoria ",
			"Europe/Warsaw"                  => "(GMT+2:00) Warsaw ",
			"Europe/Prague"                  => "(GMT+2:00) Prague Bratislava ",
			"Europe/Budapest"                => "(GMT+2:00) Budapest ",
			"Africa/Tripoli"                 => "(GMT+2:00) Tripoli ",
			"Africa/Cairo"                   => "(GMT+2:00) Cairo ",
			"Africa/Johannesburg"            => "(GMT+2:00) Johannesburg ",
			"Europe/Helsinki"                => "(GMT+3:00) Helsinki ",
			"Africa/Nairobi"                 => "(GMT+3:00) Nairobi ",
			"Europe/Sofia"                   => "(GMT+3:00) Sofia ",
			"Europe/Istanbul"                => "(GMT+3:00) Istanbul ",
			"Europe/Athens"                  => "(GMT+3:00) Athens ",
			"Europe/Bucharest"               => "(GMT+3:00) Bucharest ",
			"Asia/Nicosia"                   => "(GMT+3:00) Nicosia ",
			"Asia/Beirut"                    => "(GMT+3:00) Beirut ",
			"Asia/Damascus"                  => "(GMT+3:00) Damascus ",
			"Asia/Jerusalem"                 => "(GMT+3:00) Jerusalem ",
			"Asia/Amman"                     => "(GMT+3:00) Amman ",
			"Europe/Moscow"                  => "(GMT+3:00) Moscow ",
			"Asia/Baghdad"                   => "(GMT+3:00) Baghdad ",
			"Asia/Kuwait"                    => "(GMT+3:00) Kuwait ",
			"Asia/Riyadh"                    => "(GMT+3:00) Riyadh ",
			"Asia/Bahrain"                   => "(GMT+3:00) Bahrain ",
			"Asia/Qatar"                     => "(GMT+3:00) Qatar ",
			"Asia/Aden"                      => "(GMT+3:00) Aden ",
			"Africa/Khartoum"                => "(GMT+3:00) Khartoum ",
			"Africa/Djibouti"                => "(GMT+3:00) Djibouti ",
			"Africa/Mogadishu"               => "(GMT+3:00) Mogadishu ",
			"Europe/Kiev"                    => "(GMT+3:00) Kiev ",
			"Asia/Dubai"                     => "(GMT+4:00) Dubai ",
			"Asia/Muscat"                    => "(GMT+4:00) Muscat ",
			"Asia/Tehran"                    => "(GMT+4:30) Tehran ",
			"Asia/Kabul"                     => "(GMT+4:30) Kabul ",
			"Asia/Baku"                      => "(GMT+5:00) Baku, Tbilisi, Yerevan ",
			"Asia/Yekaterinburg"             => "(GMT+5:00) Yekaterinburg ",
			"Asia/Tashkent"                  => "(GMT+5:00) Islamabad, Karachi, Tashkent ",
			"Asia/Calcutta"                  => "(GMT+5:30) India ",
			"Asia/Kolkata"                   => "(GMT+5:30) Mumbai, Kolkata, New Delhi ",
			"Asia/Kathmandu"                 => "(GMT+5:45) Kathmandu ",
			"Asia/Novosibirsk"               => "(GMT+6:00) Novosibirsk ",
			"Asia/Almaty"                    => "(GMT+6:00) Almaty ",
			"Asia/Dacca"                     => "(GMT+6:00) Dacca ",
			"Asia/Dhaka"                     => "(GMT+6:00) Astana, Dhaka ",
			"Asia/Krasnoyarsk"               => "(GMT+7:00) Krasnoyarsk ",
			"Asia/Bangkok"                   => "(GMT+7:00) Bangkok ",
			"Asia/Saigon"                    => "(GMT+7:00) Vietnam ",
			"Asia/Jakarta"                   => "(GMT+7:00) Jakarta ",
			"Asia/Irkutsk"                   => "(GMT+8:00) Irkutsk, Ulaanbaatar ",
			"Asia/Shanghai"                  => "(GMT+8:00) Beijing, Shanghai ",
			"Asia/Hong_Kong"                 => "(GMT+8:00) Hong Kong ",
			"Asia/Taipei"                    => "(GMT+8:00) Taipei ",
			"Asia/Kuala_Lumpur"              => "(GMT+8:00) Kuala Lumpur ",
			"Asia/Singapore"                 => "(GMT+8:00) Singapore ",
			"Australia/Perth"                => "(GMT+8:00) Perth ",
			"Asia/Yakutsk"                   => "(GMT+9:00) Yakutsk ",
			"Asia/Seoul"                     => "(GMT+9:00) Seoul ",
			"Asia/Tokyo"                     => "(GMT+9:00) Osaka, Sapporo, Tokyo ",
			"Australia/Darwin"               => "(GMT+9:30) Darwin ",
			"Australia/Adelaide"             => "(GMT+9:30) Adelaide ",
			"Asia/Vladivostok"               => "(GMT+10:00) Vladivostok ",
			"Pacific/Port_Moresby"           => "(GMT+10:00) Guam, Port Moresby ",
			"Australia/Brisbane"             => "(GMT+10:00) Brisbane ",
			"Australia/Sydney"               => "(GMT+10:00) Canberra, Melbourne, Sydney ",
			"Australia/Hobart"               => "(GMT+10:00) Hobart ",
			"Asia/Magadan"                   => "(GMT+10:00) Magadan ",
			"SST"                            => "(GMT+11:00) Solomon Islands ",
			"Pacific/Noumea"                 => "(GMT+11:00) New Caledonia ",
			"Asia/Kamchatka"                 => "(GMT+12:00) Kamchatka ",
			"Pacific/Fiji"                   => "(GMT+12:00) Fiji Islands, Marshall Islands ",
			"Pacific/Auckland"               => "(GMT+12:00) Auckland, Wellington"
        );
        return $zones_array;
	}

	 /**
     * get meeting info function
     * 
     */
    public function meeting_info( $meeting_id ){

		$post_id = Helper::get_single_data_by_meta( 'etn-zoom-meeting' , 1 , 'zoom_meeting_id', $meeting_id );
		$get_meeting_info = [];

		if ( !empty( $post_id ) ) {
			$id = $post_id[0]->ID ;
			$get_meeting_info['meeting_id'] = get_post_meta( $id ,'zoom_meeting_id',true );
			$get_meeting_info['start_url']  = get_post_meta( $id ,'zoom_start_url',true );
			$get_meeting_info['join_url']   = get_post_meta( $id ,'zoom_join_url',true );
			$get_meeting_info['host_id']    = get_post_meta( $id ,'zoom_meeting_host_id',true );
			$get_meeting_info['status']     = get_post_meta( $id ,'zoom_meeting_status',true );
			$get_meeting_info['type']       = get_post_meta( $id ,'zoom_meeting_type',true );
			$get_meeting_info['topic'] 		= get_post_meta( $id ,'zoom_topic',true );
			$get_meeting_info['start_time'] = get_post_meta( $id ,'zoom_start_time',true );
			$get_meeting_info['timezone'] 	= get_post_meta( $id ,'zoom_timezone',true );
			$get_meeting_info['duration'] 	= get_post_meta( $id ,'zoom_duration',true );
			$get_meeting_info['password'] 	= get_post_meta( $id ,'zoom_password',true );
		}

		return $get_meeting_info;
	}

	/**
	 * Meeting type list function
	 *
	 * @return void
	 */
	public function meeting_type_list(){
		$type = [ 1 => 'Instant meeting', 2 => 'Scheduled meeting',
		3 => 'Recurring meeting with no fixed time', 4 => 'PMI meeting', 8 => 'Recurring meeting with fixed time'];
		return $type;
	}

	/**
	 * Convert time
	 *
	 * @param Type $var
	 * @return void
	 */
	public function convert_meeting_date_time( $date ){
		$timestamp = strtotime( $date );
		$date = new DateTime();
		$date->setTimestamp($timestamp);

		return $date->format('d/m/Y H:i:s');
	}

	/**
	 * Get meeting details by id from API 
	 */
	public function get_meeting_details( $meeting_id ){
		return \Etn\Core\Zoom_Meeting\Api::instance()->get_meeting_details( $meeting_id );
	}
}

class Api extends \Etn\Core\Zoom_Meeting\Base_Api{
	
    use Singleton;
    
	public $data = [];
	
    /**
     * Main configuration function
     */
    public function config(){
        $settings               =  \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $zoom_api_key           =  (isset($settings['zoom_secret_key']) ? $settings['zoom_api_key'] : '');
        $zoom_secret_key        =  (isset($settings['zoom_secret_key']) ? $settings['zoom_secret_key'] : '');
        $this->zoom_api_key     = trim( $zoom_api_key );
        $this->zoom_api_secret  = trim( $zoom_secret_key );
    }

    /**
     * get user
     *
     * @return void
     */
    public function user_list(){
		$this->data['page_size'] = 300;
        return parent::init( 'users', $this->data , 'GET' );
	}
	
    /**
     * create new meeting function
     */
    public function create_meeting( $request_data ){
        if ( !empty( $request_data) ) {
			$request_data['start_time'] = gmdate( "Y-m-d\TH:i:s", strtotime( $request_data['start_time']) );
            if ( empty( $request_data['meeting_id'] ) ) {
				$accepted_name = ['start_time','timezone','topic','duration','password'];
				$user_id = $request_data['user_id'];
				foreach ($request_data as $key => $value) {
					if ( !in_array($key,$accepted_name) ) {
						unset($request_data[$key]);
					}
				}
				$request_data['type'] = 2 ;
				$this->data = $request_data;
				$data =  parent::init( 'users/' . $user_id . '/meetings' , $this->data , 'POST' );
            } else {
                $meeting_id = $request_data['meeting_id'];
                unset($request_data['meeting_id']);
				$this->data = $request_data;
				$data =  parent::init( 'meetings/' . $meeting_id , $this->data , 'PATCH' );
			}
            return $data;
        }
	}

	/**
	 * Get meeting details by id from API 
	 */
	public function get_meeting_details( $meeting_id ){
		return parent::init( 'meetings/' . $meeting_id , [] ,'GET' );
	}
}
