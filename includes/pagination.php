<?php 
	// Helper class

	class pagination {
		public $currentPage;
		public $perPage;
		public $totalCount;

		public function __construct($page=1, $perPage=20,$totalPage=0){
			$this->currentPage = (int)$page;
			$this->perPage = $perPage;
			$this->totalCount = $totalPage;
		}
		public function offset(){
			return ($this->currentPage-1) * $this->perPage;
		}
		public function totalPage(){
			return ceil($this->totalCount/$this->perPage);
		}
		public function previousPage(){
			return $this->currentPage-1;
		}
		public function nextPage(){
			return $this->currentPage+1;
		}
		public function hasPreviousPage(){
			return $this->previousPage()>=1 ? true : false;
		}
		public function hasNextPage(){
			return $this->nextPage() <= $this->totalPage() ? true : false;
		}
	}
?>