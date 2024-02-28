<?php 
#[AllowDynamicProperties]
 

 class Pages_model extends CI_Model

 {

 	

 	function __construct()

 	{

 		parent::__construct();

 		$this->load->database();

 		$this->table_name="sitecontent";

 	}



	 function checkJobCategoryExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_categories');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_categories');

			return $this->db->insert_id();

		}

	 }



	 function checkJobIndustryExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_industries');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_industries');

			return $this->db->insert_id();

		}

	 }



	 function checkCompanyExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_companies');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_companies');

			return $this->db->insert_id();

		}

	 }



	function checkLevelExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_levels');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_levels');

			return $this->db->insert_id();

		}

	 }

	function checkCountryExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_countries');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_countries');

			return $this->db->insert_id();

		}

	 }



	 function checkLocationExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_locations');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_locations');

			return $this->db->insert_id();

		}

	 }



	 function checkDegreeExist($val)

	 {

		$this->db->where(['LOWER(title)'=> $val, 'status'=> 1]);

		$this->db->from('job_degree');

		$row = $this->db->get()->row();



		if(!empty($row))

		{

			return $row->id;

		}

		else

		{

			$arr = [];

			$arr['title'] = $val;

			$arr['status'] = 1;

			$this->db->set($arr);

			$this->db->insert('job_degree');

			return $this->db->insert_id();

		}

	 }



 	function savePageContent($vals,$page_slug=""){

 		$this->db->set($vals);

 		if($page_slug != ""){

 			//die("here");

 			$this->db->where("ckey",$page_slug);

 			$this->db->update($this->table_name);

 			return $page_slug;

 		}	 		

 		else{

 			$this->db->insert($this->table_name);

 			return $this->db->insert_id();

 		}

 	}

 	function saveMetaContent($vals,$page_slug=""){

 		$this->db->set($vals);

 		if($page_slug != ""){

 			//die("here");

 			$this->db->where("slug",$page_slug);

 			$this->db->update('meta_info');

 			return $page_slug;

 		}	 		

 		else{

 			$this->db->insert('meta_info');

 			return $this->db->insert_id();

 		}

 	}

	 function getJobCities()

	 {

		 $this->db->from('jobs');

		 $this->db->where(['status'=> 1]);

		 $this->db->select('city');

		 $this->db->distinct();

		 return $this->db->get()->result();

	 }

 	function getPageContent($page_slug=""){

 		if($page_slug != ""){

 			$this->db->where("ckey",$page_slug);

 			return $this->db->get($this->table_name)->row();

 		}

 		else{

 			 return $this->db->get($this->table_name)->result();

 		}

 	}

 	 function getMetaContent($page_slug=""){

 		if($page_slug != ""){

 			$this->db->where("slug",$page_slug);

 			return $this->db->get('meta_info')->row();

 		}

 		else{

 			 return $this->db->get('meta_info')->result();

 		}

 	}

 	function deletePage($page_slug=""){

 		$this->where("ckey",$page_slug);

 		$this->db->delete($this->table_name);

 		return $page_slug;	

 	}



	function get_products($post)

	{

		$this->db->select('*, (price - discount) as final_price');

		$this->db->from('products');

		$this->db->where('category_id', $post['category']);



		if(isset($post['price']) && !empty(trim($post['price'])))

		{

		  $priceIndex = explode(';', $post['price']);

		  $this->db->where(['(price - discount) >='=> $priceIndex[0], '(price - discount) <='=> $priceIndex[1]]);

		}



		if(isset($post['types']) && !empty($post['types']))

		{

			$this->db->group_start();

			foreach($post['types'] as $key => $value)

			{

				if($key == 0)

					$this->db->where('phone_type', $value);

				else

					$this->db->or_where('phone_type', $value);

			}

			$this->db->group_end();

		}



		if(isset($post['brands']) && !empty($post['brands']))

		{

			$this->db->group_start();

			foreach($post['brands'] as $key => $value)

			{

				if($key == 0)

					$this->db->where('brand_id', $value);

				else

					$this->db->or_where('brand_id', $value);

			}

			$this->db->group_end();

		}



		$this->db->where(['status'=> 1]);

		$this->db->order_by('id', 'DESC');

		return $this->db->get()->result();

		// pr($this->db->last_query());



	}



	

	function getBlogsByCat($cat_id, $start, $offset)
	{
		$this->db->select('b.*, bc.category_id');
		$this->db->from('blogs b');
		$this->db->join('selected_blog_categories bc', 'b.id=bc.blog_id');
		$this->db->where(['bc.category_id'=> $cat_id, 'b.status'=> 1]);
		$this->db->limit($offset, $start);
		$this->db->order_by('b.id', 'DESC');
		return $this->db->get()->result();
	}
	function getBlogsByCatTotal($cat_id)
	{
		$this->db->select('b.*');
		$this->db->from('blogs b');
		$this->db->join('selected_blog_categories bc', 'b.id=bc.blog_id');
		$this->db->where(['bc.category_id'=> $cat_id, 'b.status'=> 1]);
		return $this->db->get()->num_rows();
	}

	function fetch_jobs_data($post)

	{	

		$offset = ($post['pageNo'] - 1) * $post['jobsPerPage'];

		$this->db->select('j.*');

		$this->db->from('jobs j');

		$this->db->join('job_companies com', 'j.company_name=com.id');

		$this->db->join('job_locations loc', 'j.city=loc.id');



		if(isset($post['jobCats']) && !empty($post['jobCats']))

		{

			$this->db->group_start();

			foreach($post['jobCats'] as $key => $value)

			{

				if($key == 0)

					$this->db->where('j.job_industry', $value);

				else

					$this->db->or_where('j.job_industry', $value);

			}

			$this->db->group_end();

		}



		if(isset($post['countries']) && !empty($post['countries']))

		{

			$this->db->group_start();

			foreach($post['countries'] as $key => $value)

			{

				$value = str_replace('"', '', $value);

				if($key == 0)

					$this->db->where('j.job_country', $value);

				else

					$this->db->or_where('j.job_country', $value);

			}

			$this->db->group_end();

		}

		

		if(isset($post['subTypes']) && !empty($post['subTypes']))

		{

			$this->db->group_start();

			foreach($post['subTypes'] as $key => $value)

			{

				$value = str_replace('"', '', $value);

				if($key == 0)

					$this->db->where('j.job_level', $value);

				else

					$this->db->or_where('j.job_level', $value);

			}

			$this->db->group_end();

		}



		if(isset($post['searchKeyword']) && !empty($post['searchKeyword']) && $post['searchKeyword'] != 'null')

		{

			$keyword = trim($post['searchKeyword']);

			$this->db->group_start();

			$this->db->like('j.title', $keyword);

			$this->db->or_like('com.title', $keyword);

			$this->db->group_end();

		}



		if(isset($post['location']) && !empty($post['location']) && $post['location'] != 'null')

		{

			$locationIndex = explode('@', $post['location']);

			$type = $locationIndex[0];

			$value = (int)$locationIndex[1];

			$this->db->group_start();

			if($type == 'city')

				$this->db->where('loc.id', $value);

			else

				$this->db->where('j.job_country', $value);

			$this->db->group_end();

		}

		



		$this->db->where(['j.status'=> 1, 'is_deleted'=> 0]);

		$this->db->where(['j.job_expire >' => date('Y-m-d')]);

		if(!empty($post['sortBy']))

		{

			$this->db->order_by('j.is_promoted desc, j.id '.$post['sortBy'].'');

		}

		else

		{

			$this->db->order_by('j.is_promoted desc, j.id desc');

		}

		$this->db->limit($post['jobsPerPage'], $offset);

		return $this->db->get()->result();

	}



	function totalJobs($post)

	{	

		$this->db->select('j.*');

		$this->db->from('jobs j');

		$this->db->join('job_companies com', 'j.company_name=com.id');

		$this->db->join('job_locations loc', 'j.city=loc.id');



		if(isset($post['jobCats']) && !empty($post['jobCats']))

		{

			$this->db->group_start();

			foreach($post['jobCats'] as $key => $value)

			{

				if($key == 0)

					$this->db->where('j.job_industry', $value);

				else

					$this->db->or_where('j.job_industry', $value);

			}

			$this->db->group_end();

		}



		if(isset($post['countries']) && !empty($post['countries']))

		{

			$this->db->group_start();

			foreach($post['countries'] as $key => $value)

			{

				$value = str_replace('"', '', $value);

				if($key == 0)

					$this->db->where('j.job_country', $value);

				else

					$this->db->or_where('j.job_country', $value);

			}

			$this->db->group_end();

		}

		

		if(isset($post['subTypes']) && !empty($post['subTypes']))

		{

			$this->db->group_start();

			foreach($post['subTypes'] as $key => $value)

			{

				$value = str_replace('"', '', $value);

				if($key == 0)

					$this->db->where('j.job_level', $value);

				else

					$this->db->or_where('j.job_level', $value);

			}

			$this->db->group_end();

		}



		if(isset($post['searchKeyword']) && !empty($post['searchKeyword']) && $post['searchKeyword'] != 'null')

		{

			$keyword = trim($post['searchKeyword']);

			$this->db->group_start();

			$this->db->like('j.title', $keyword);

			$this->db->or_like('com.title', $keyword);

			$this->db->group_end();

		}



		if(isset($post['location']) && !empty($post['location']) && $post['location'] != 'null')

		{

			$locationIndex = explode('@', $post['location']);

			$type = $locationIndex[0];

			$value = (int)$locationIndex[1];

			$this->db->group_start();

			if($type == 'city')

				$this->db->where('loc.id', $value);

			else

				$this->db->where('j.job_country', $value);

			$this->db->group_end();

		}

		



		$this->db->where(['j.status'=> 1, 'is_deleted'=> 0]);

		$this->db->where(['j.job_expire >' => date('Y-m-d')]);

		return $this->db->get()->result();



	}



	function getCityCountryByJob($cityId)

	{

		$this->db->select('*');

		$this->db->from('jobs');

		$this->db->where(['status'=> 1, 'job_expire >' => date('Y-m-d'), 'city'=> $cityId]);

		$this->db->order_by('id', 'desc');

		$this->db->limit(1);

		return $this->db->get()->row()->job_country;

	}

	function getJobs()

	{

		$this->db->select('*');

		$this->db->from('jobs');

		$this->db->where(['status'=> 1, 'job_expire >' => date('Y-m-d')]);

		$this->db->order_by('is_promoted desc, id desc');

		return $this->db->get()->result();

		// pr($this->db->last_query());

	}



	function getMemberSubscription($mem_id)

	{

		$this->db->select('*');

		$this->db->from('subscribed_plans');

		$this->db->where("mem_id", $mem_id);

		$this->db->order_by('id', 'desc');

		$this->db->limit(1);

		return $this->db->get()->result();

	}



	function getPreviosNextRecord($table, $id, $type)

	{

		$this->db->from($table);

		$this->db->select('*');

		$this->db->where(['status'=> 1]);

		if($type == 'next')

		{

			$this->db->order_by('id', 'asc');

			$this->db->where(['id >'=> $id]);

		}

		else{

			$this->db->order_by('id', 'desc');

			$this->db->where(['id <'=> $id]);

		}

		$this->db->limit(1);

		return $this->db->get()->row();

	}



	function getCancelledSubscriptions()

	{

		$this->db->select('*');

		$this->db->from('subscribed_plans');

		$this->db->where("status", '0');

		$this->db->or_where("status", '2');

		$this->db->order_by('id', 'desc');

		return $this->db->get()->result();

	}



	function getMemberSubscriptionActive($mem_id)

	{

		$this->db->select('*');

		$this->db->from('subscribed_plans');

		$this->db->where("mem_id", $mem_id);

		$this->db->where("status", '1');

		$this->db->order_by('id', 'desc');

		$this->db->limit(1);

		return $this->db->get()->row();

	}



	function getFeaturedCategoryJobs($cat)

	{

		$cat = strtolower($cat);

		$this->db->select('id');

		$this->db->from('job_categories');

		$this->db->where('LOWER(title)', $cat);

		$this->db->order_by('id', 'asc');

		$this->db->limit(1);

		$cat_id = $this->db->get()->row()->id;



		$this->db->select('*');

		$this->db->from('jobs');

		$this->db->where(['status'=> 1, 'job_expire >' => date('Y-m-d'), 'is_featured'=> 1, 'job_cat'=> $cat_id]);

		$this->db->order_by('is_promoted desc, id desc');

		$this->db->limit(5, 0);

		return $this->db->get()->result();

		// pr($this->db->last_query());

	}

	function getFeaturedJobs()

	{

		$this->db->select('*');

		$this->db->from('jobs');

		$this->db->where(['status'=> 1, 'job_expire >' => date('Y-m-d'), 'is_featured'=> 1, 'is_deleted'=> 0]);

		$this->db->order_by('is_promoted desc, id desc');

		$this->db->limit(9, 0);

		return $this->db->get()->result();

	}



	function getRegisteredEvents($mem_id)

	{

		$this->db->select('e.*');

		$this->db->from('events e');

		$this->db->join('registered_events r', 'e.id=r.event_id');

		$this->db->where(['e.status'=> 1]);

		$this->db->where(['r.mem_id'=> $mem_id]);

		$this->db->order_by('event_date', 'asc');

		return $this->db->get()->result();

	}

	function getSaved_jobs($mem_id)

	{

		$this->db->select('j.*, s.created_at as saved_at');

		$this->db->from('jobs j');

		$this->db->join('saved_jobs s', 'j.id=s.job_id');

		$this->db->where(['s.mem_id'=> $mem_id]);

		return $this->db->get()->result();

	}



	function get_internal_jobs_applications()

	{

		$this->db->select('a.*');

		$this->db->from('applied_jobs a');

		$this->db->join('jobs j', 'a.job_id=j.id');

		$this->db->where(['j.is_internal_or_external' => 'internal']);

		return $this->db->get()->result();

	}



	function get_applied_jobs($mem_id)

	{

		$this->db->select('j.*, a.job_status, a.created_at as applied_at');

		$this->db->from('jobs j');

		$this->db->join('applied_jobs a', 'j.id=a.job_id');

		$this->db->where(['a.mem_id'=> $mem_id]);

		return $this->db->get()->result();

	}

	

	function fetch_events_data($post)

	{

		$this->db->select('*');

		$this->db->from('events');

		// pr($post);

		if(isset($post['dateRange']) && !empty(trim($post['dateRange'])))

		{

			$today = date('Y-m-d');

			if($today === $post['dateRange'])

			{

				$this->db->where('event_date', $today);

			}

			else

			{

				$this->db->where(['event_date >='=> $today, 'event_date <='=> $post['dateRange']]);

			}

			

		}

		

		$this->db->where(['status'=> 1]);

		$this->db->order_by('event_date', 'asc');

		return $this->db->get()->result();

		// pr($this->db->last_query());



	}



 }







?>

