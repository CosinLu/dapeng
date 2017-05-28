<?php

/**
 * 加载sdk包以及错误代码包
 */
require_once '../sdk.class.php';

class PicClient
{
	private $_ossServer;
	private $_bucket;


	public function __construct()
	{
		$this->_bucket = 'bowertest';

		$this->_ossServer = new ALIOSS();

		// 设置是否打开curl调试模式
		$this->_ossServer->set_debug_mode(FALSE);

		// 设置开启三级域名，三级域名需要注意，域名不支持一些特殊符号，所以在创建bucket的时候若想使用三级域名，最好不要使用特殊字符
		// $this->_ossServer->set_enable_domain_style(TRUE);
	}


	// Object 相关

	/**
	 * 获取object列表
	 */
	public function listObject()
	{
		$options = array(
			'delimiter' => '/',
			'prefix' => '',
			'max-keys' => 10,
			//'marker' => 'myobject-1330850469.pdf',
		);

		$response = $this->_ossServer->list_object($this->_bucket, $options);	
		$this->_format($response);
	}


	/**
	 * 通过路径上传文件
	 * @param string $file_path
	 * @param string $filename
	 * @return array
	 */
	public function uploadByFile($file_path, $filename)
	{
		// $bucket = 'phpsdk1349849394';
		// $object = 'netbeans-7.1.2-ml-cpp-linux.sh';	
		// $file_path = "D:\\TDDOWNLOAD\\netbeans-7.1.2-ml-cpp-linux.sh";
		
		if (empty($filename))
		{
			$pathParts = pathinfo($file_path);
			$fileName = $pathParts['filename'];
			$extension = $pathParts['extension'];
		}

		$secret = md5($pathParts['filename'] . '|360IMG|');
		$tmpStr = substr($secret, 0, 9);
		$object = $tmpStr . $pathParts['extension'];

		$response = $this->_ossServer->upload_file_by_file($this->_bucket, $object, $file_path);
		_format($response);
	}












	//格式化返回结果
	private function _format($response) {
		echo '|-----------------------Start---------------------------------------------------------------------------------------------------'."<br>";
		echo '|-Status:' . $response->status . "<br>";
		echo '|-Body:' ."<br>"; 
		echo $response->body . "<br><br>";
		echo "|-Header:<br>";
		print_r ( $response->header );
		echo '<br>-----------------------End-----------------------------------------------------------------------------------------------------'."<br><br>";
	}
}

// $pic = new PicClient();

// $pic->listObject();



// echo <<<HTML

// <form method="post" enctype="multipart/form-data">

// 	<input type="file" name="upload_file" /><br>
// 	<input type="submit" />

// </form>
// HTML;

// echo '<pre>';
// var_export($_FILES);