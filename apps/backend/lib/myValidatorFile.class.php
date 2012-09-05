<?php

class myValidatorFile extends sfValidatorFile{
  public function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);
		$this->setOption('required',true);
		$this->setMessage('required','Required, please choose your file');
		
    $this->setOption(
		'mime_types', array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/gif',
				'application/pdf'
      )
		);
		$this->setMessage('mime_types', 'Disallowed file type, allowed file types are: jpg, png, gif, pdf');
		
		$this->setOption('max_size', '10240000');
		$this->setMessage('max_size', 'Maximum file size exceed, make sure your uploaded file is not more than 10MB');
		
		$this->setOption('validated_file_class', 'myValidatedFile');
  }
}
