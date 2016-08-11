<?php
#ä

class AdminController extends Controller
{

	public function index()
	{

	}

	public function translation()
	{
		// view
		$this->Layout()->load('admin/translation');
		$this->Layout()->show();
	}

}