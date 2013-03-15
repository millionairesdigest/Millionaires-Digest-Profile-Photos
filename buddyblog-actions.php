<?php
class BuddyBlogActions{
    
    private static $instance;
    
    private function __construct() {
        //do something here
            //register forms
        /**
         * Register form for new/edit resume
         */
        if(is_admin())
            return;
        add_action('bp_init',array($this,'register_form'),7);
        add_action('bp_actions',array($this,'publish'));
        add_action('bp_actions',array($this,'unpublish'));
        
        
    }

    public static function get_instance(){
        
        if(!isset (self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    
    /**
     * Create Posts screen
     */
    function create(){
        //No Need to implement it, BP Simple FEEditor takes care of this
    }
    /**
     * Edit Posts screen
     */
    function edit(){
        //No Need to implement it, BP Simple FEEditor takes care of this
    }
    /**
     * delete Post screen
     */
    function delete(){
        //
        
    }
    /**
     * Publish Post
     */
    function publish(){
       if(!(bp_is_buddyblog_component()&&  bp_is_current_action('publish')))
           return;
           
        $id=  bp_action_variable(0);
        if(!$id)
            return;
       
        if(buddyblog_user_can_publish(get_current_user_id(),$id)){
            wp_publish_post($id);//change status to publish         
           bp_core_add_message(__('Post Published','buddyblog'));   
        }
        bp_core_redirect(buddyblog_get_home_url());
    }
    /**
     * Unpublish a post
     */
    function unpublish(){
         if(!(bp_is_buddyblog_component()&&  bp_is_current_action('unpublish')))
           return;
        $id=  bp_action_variable(0);
        if(!$id)
            return;
         if(buddyblog_user_can_unpublish(get_current_user_id(),$id)){
               $post = get_post($id, ARRAY_A);
            $post['post_status']='draft';
            wp_update_post($post);
             //unpublish
                bp_core_add_message(__('Post unpublished','buddyblog'));
                
         }
         
         bp_core_redirect(buddyblog_get_home_url());
         
    }
    
    

/**
 * register post form for Posting/editing
 * @return type 
 */

function register_form(){
    //make sure the Front end simple post plugin is active
    if(!function_exists('bp_new_simple_blog_post_form'))
        return;
    
    $post_status='publish';
    $user_id=get_current_user_id();
    
     if(!buddyblog_user_can_post($user_id))
         $post_status='draft';
        
    
    $settings=array(
        'post_type'=> buddyblog_get_posttype(),
        'post_status'=>$post_status,
        'comment_status'=>'open',
        'show_comment_option'=>true,
              
        'tax'=>array(
                   'category'=>array('taxonomy'=>'category',
                                    'view_type'=>'checkbox'
                                ),
                   'post_tag'=>array('taxonomy'=>'post_tag',
                                     'view_type'=>'checkbox'
                                )
          
                ),  
        'upload_count'=>2
        );
    
   //use it to add extra fields or filter the post type etc
    
    $settings=apply_filters('buddyblog_post_form_settings',$settings);
   
   bp_new_simple_blog_post_form('buddyblog-user-posts', $settings);// the blog form
    
  
 
}
}    

BuddyBlogActions::get_instance();
