<?php
defined('BASEPATH') OR exit('');

class functions_model extends CI_Model
{
    public function page_transfer($msg, $page = "home") {
        $data['msg'] = $msg;
        $data['url'] = $page;
        $this->load->view("transfer", $data);
    }

    public function pagination($base_url, $count, $perpage, $num_link, $query = false) {
        $config['base_url'] = $base_url;
        $config['total_rows'] = $count;
        $config['per_page'] = $perpage;
        if($query == true) {
            $config['first_url'] = '0' . $this->config->item('url_suffix') . '?' . $_SERVER['QUERY_STRING'];
        } else {
            $config['first_url'] = '0' . $this->config->item('url_suffix');
        }

        $config['next_tag_open'] = '<li class="paginate_button page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="paginate_button page-item">';
        $config['first_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="paginate_button page-item">';
        $config['first_link'] = '&lsaquo;&lsaquo; Đầu';
        $config['last_link'] = 'Cuối &rsaquo;&rsaquo;';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="paginate_button page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] =  '<li class="paginate_button page-item">';
        $config['num_tag_close'] =  '</li>';
        $config['num_links']	=  $num_link;
        $config['cur_tag_open'] =  '<li class="paginate_button page-item active"><a href="#" aria-controls="datatable" class="page-link">';
        $config['cur_tag_close'] =  '</a></li>';
        $config['attributes'] = array('class' => 'page-link', 'aria-controls' => 'datatable');
        $config['uri_segment']	 =  3;
        $config['reuse_query_string'] = true;
        $config['suffix'] = $this->config->item('url_suffix');

        return $config;
    }
    public function non_signed($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }
    public function dbDateTime($strDateTime){
        if($strDateTime == '' || empty($strDateTime) || (strpos($strDateTime, '/')  === false && strpos($strDateTime, '-')  === false)) return '';
        $dts = explode(' ', $strDateTime);
        $date = date('Y-m-d', strtotime(implode('-', array_reverse(explode('/',$dts[0])))));
        $datetime = isset($dts[1]) ? date('Y-m-d H:i:s', strtotime($date.$dts[1])) : date('Y-m-d H:i:s', strtotime($date.' 00:00:00'));
        return $datetime;
    }
    public function clientDateTime($strDateTime){
        if($strDateTime == '' || empty($strDateTime) || (strpos($strDateTime, '/')  === false && strpos($strDateTime, '-')  === false)) return '';
        $dts = explode(' ', $strDateTime);
        $date = date('d-m-Y', strtotime(implode('-', array_reverse(explode('-',$dts[0])))));
        $datetime = isset($dts[1]) ? date('d-m-Y H:i:s', strtotime($date.$dts[1])) : date('d-m-Y H:i:s', strtotime($date.' 00:00:00'));
        return $datetime;
    }
    public function array_search2d_value($needle, $haystack) {
        foreach ($haystack as $k=>$v ) {
            if (is_array($v) && in_array($needle, $v)) return $v;
        }
        return false;
    }

    public function convert_number_to_words($number) {

        $hyphen      = ' ';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'âm ';
        $decimal     = ' phẩy ';
        $dictionary  = array(
            0                   => 'Không',
            1                   => 'Một',
            2                   => 'Hai',
            3                   => 'Ba',
            4                   => 'Bốn',
            5                   => 'Năm',
            6                   => 'Sáu',
            7                   => 'Bảy',
            8                   => 'Tám',
            9                   => 'Chín',
            10                  => 'Mười',
            11                  => 'Mười một',
            12                  => 'Mười hai',
            13                  => 'Mười ba',
            14                  => 'Mười bốn',
            15                  => 'Mười năm',
            16                  => 'Mười sáu',
            17                  => 'Mười bảy',
            18                  => 'Mười tám',
            19                  => 'Mười chín',
            20                  => 'Hai mươi',
            30                  => 'Ba mươi',
            40                  => 'Bốn mươi',
            50                  => 'Năm mươi',
            60                  => 'Sáu mươi',
            70                  => 'Bảy mươi',
            80                  => 'Tám mươi',
            90                  => 'Chín mươi',
            100                 => 'trăm',
            1000                => 'ngàn',
            1000000             => 'triệu',
            1000000000          => 'tỷ',
            1000000000000       => 'nghìn tỷ',
            1000000000000000    => 'ngàn triệu triệu',
            1000000000000000000 => 'tỷ tỷ'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        $string = ucfirst(strtolower($string));
        return $string;
    }
}