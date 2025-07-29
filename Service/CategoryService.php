<?php 
    class CategoryService
    {
        protected $category;
        protected $subcategory;

        function __construct(Category $category, SubCategory $subcategory)
        {
            $this->category     = $category;
            $this->subcategory  = $subcategory;
        }
    }
?>