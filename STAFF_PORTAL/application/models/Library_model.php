<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Library_model extends CI_Model
{

    public function getAllLibraryMgmtCount($filter=''){
        $this->db->from('tbl_library_managemnt as library'); 
      
        if(!empty($filter['access_no'])){
            $this->db->where('library.access_code', $filter['access_no']);
        }
        if(!empty($filter['isbn'])){
            $this->db->where('library.isbn', $filter['isbn']);
        }
        if(!empty($filter['category'])){
            $this->db->where('library.category', $filter['category']);
        }
        if(!empty($filter['book_title'])){
            $this->db->where('library.book_title', $filter['book_title']);
        }
        if(!empty($filter['author_name'])){
            $this->db->where('library.author_name', $filter['author_name']);
        }
        if(!empty($filter['publisher_name'])){
            $this->db->where('library.publisher_name', $filter['publisher_name']);
        }
        if(!empty($filter['shelf_no'])){
            $this->db->where('library.shelf_no', $filter['shelf_no']);
        }
        if(!empty($filter['bill_date'])){
            $this->db->where('library.bill_date', $filter['bill_date']);
        }
        if(!empty($filter['bill_no'])){
            $this->db->where('library.bill_no', $filter['bill_no']);
        }
        if(!empty($filter['price'])){
            $this->db->where('library.price', $filter['price']);
        }
        if(!empty($filter['no_of_copies'])){
            $this->db->where('library.no_of_copies', $filter['no_of_copies']);
        }
        if(!empty($filter['year'])){
            $this->db->where('library.year', $filter['year']);
        }
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllLibraryMgmtInfo($filter, $page, $segment){
        $this->db->from('tbl_library_managemnt as library'); 
        if(!empty($filter['access_no'])){
            $this->db->where('library.access_code', $filter['access_no']);
        }
        if(!empty($filter['isbn'])){
            $this->db->where('library.isbn', $filter['isbn']);
        }
        if(!empty($filter['category'])){
            $this->db->where('library.category', $filter['category']);
        }
        if(!empty($filter['book_title'])){
            $this->db->where('library.book_title', $filter['book_title']);
        }
        if(!empty($filter['author_name'])){
            $this->db->where('library.author_name', $filter['author_name']);
        }
        if(!empty($filter['publisher_name'])){
            $this->db->where('library.publisher_name', $filter['publisher_name']);
        }
        if(!empty($filter['shelf_no'])){
            $this->db->where('library.shelf_no', $filter['shelf_no']);
        }
        if(!empty($filter['bill_date'])){
            $this->db->where('library.bill_date', $filter['bill_date']);
        }
        if(!empty($filter['bill_no'])){
            $this->db->where('library.bill_no', $filter['bill_no']);
        }
        if(!empty($filter['price'])){
            $this->db->where('library.price', $filter['price']);
        }
        if(!empty($filter['no_of_copies'])){
            $this->db->where('library.no_of_copies', $filter['no_of_copies']);
        }
        if(!empty($filter['year'])){
            $this->db->where('library.year', $filter['year']);
        }
        $this->db->where('library.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function addLibraryMgmtInfo($libraryInfo) {
        $this->db->trans_start();
        $this->db->insert_batch('tbl_library_managemnt',$libraryInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function checkIsbnNumberExists($isbn){
        $this->db->from('tbl_library_managemnt as library');
        $this->db->where('library.isbn', $isbn);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function updateLibraryInfo($libraryInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_managemnt', $libraryInfo);
        return TRUE;
    }

    public function getCategoryInfo(){
        $this->db->from('tbl_library_category as category');
        $this->db->where('category.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAuthorInfo(){
        $this->db->from('tbl_library_author as author');
        $this->db->where('author.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPublisherInfo(){
        $this->db->from('tbl_library_publisher as publisher');
        $this->db->where('publisher.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addBookCategory($categoryInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_category',$categoryInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateCategoryInfo($categoryInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_category', $categoryInfo);
        return TRUE;
    }

    public function addBookAuthor($authorInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_author',$authorInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateAuthorInfo($authorInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_author', $authorInfo);
        return TRUE;
    }

    public function addBookPublisher($publisherInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_publisher',$publisherInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updatePublisherInfo($publisherInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_publisher', $publisherInfo);
        return TRUE;
    }

    public function getLibraryInfoById($row_id){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.row_id', $row_id);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateBookInfo($row_id,$libraryInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_managemnt', $libraryInfo);
        return TRUE;
    }

    public function getShelfInfo(){
        $this->db->from('tbl_library_shelf as shelf');
        $this->db->where('shelf.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addShelfNo($shelfInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_shelf',$shelfInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateShelfNo($shelfInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_shelf', $shelfInfo);
        return TRUE;
    }

    function getAllStudentInfo(){
        $this->db->select('student.student_name,student.term_name,student.student_id,student.section_name,student.application_no,student.stream_name');
        $this->db->from('tbl_students_info as student'); 
        //$this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
       // $this->db->where('academic.is_current', 1);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        //$this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllStaffInfo()
    {
        $this->db->select('staff.type, staff.row_id, staff.staff_id, 
        staff.email, staff.name,dept.name as department,
         staff.mobile, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getAllIsbnInfo(){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.is_available', 1);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getIsbnData($isbn){
        $this->db->from('tbl_library_managemnt as library');
        $this->db->where('library.isbn', $isbn);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addLibraryMgmtIssueInfo($issedInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_issue_info',$issedInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateIsAvailable($libraryInfo,$access_code){
        $this->db->where('access_code', $access_code);
        $this->db->update('tbl_library_managemnt', $libraryInfo);
        return TRUE;
    }

    function getFineInfo(){
        $this->db->from('tbl_library_fine as fine');
        $this->db->where('fine.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addFineInfo($fineInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_fine',$fineInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateFineInfo($fineInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_fine', $fineInfo);
        return TRUE;
    }

    public function getAllIssuedBookCount($filter=''){
        $this->db->from('tbl_library_issue_info as issue'); 
        //$this->db->join('tbl_library_managemnt as mgmt','mgmt.access_code = issue.access_code','left');
        if($filter['user_type'] == 'student'){
            $this->db->select('issue.access_code, issue.isbn, issue.student_id,issue.row_id,library.book_title, 
            issue.issue_date, issue.return_date,issue.actual_return_date,student.student_name,
            issue.fine, issue.days_delayed, issue.remarks,issue.is_issued');

        $this->db->join('tbl_students_info as student','student.student_id = issue.student_id','left');
        $this->db->join('tbl_library_managemnt as library','library.access_code = issue.access_code','left');


        if(!empty($filter['access_code'])){
            $this->db->where('issue.access_code', $filter['access_code']);
        }
        if(!empty($filter['book_title'])) {
            $like = "(library.book_title  LIKE '%".$filter['book_title']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('issue.student_id', $filter['student_id']);
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
        if(!empty($filter['issue_date'])){
            $this->db->where('issue.issue_date', $filter['issue_date']);
        }
        if(!empty($filter['return_date'])){
            $this->db->where('issue.return_date', $filter['return_date']);
        }
        if(!empty($filter['actual_return_date'])){
            $this->db->where('issue.actual_return_date', $filter['actual_return_date']);
        }
        if(!empty($filter['renewal_date'])){
            $this->db->where('issue.renewal_date', $filter['renewal_date']);
        }
        if(!empty($filter['fine'])){
            $this->db->where('issue.fine', $filter['fine']);
        }
        if(!empty($filter['days_delayed'])){
            $this->db->where('issue.days_delayed', $filter['days_delayed']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('issue.remarks', $filter['remarks']);
        }
        $this->db->where_in('issue.user_type', ['student',' ']);
        
    }else{
        $this->db->select('issue.access_code, issue.isbn, issue.student_id,issue.row_id,  
        issue.issue_date, issue.return_date,issue.actual_return_date,staff.name as student_name,library.book_title,
        issue.fine, issue.days_delayed, issue.remarks,issue.is_issued');
        $this->db->join('tbl_staff as staff','staff.staff_id = issue.student_id','left');
        $this->db->join('tbl_library_managemnt as library','library.access_code = issue.access_code','left');

        if(!empty($filter['access_code'])){
            $this->db->where('issue.access_code', $filter['access_code']);
        }
        if(!empty($filter['book_title'])) {
            $like = "(library.book_title  LIKE '%".$filter['book_title']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('issue.student_id', $filter['student_id']);
        }
        if(!empty($filter['student_name'])){
            $this->db->where('staff.name', $filter['student_name']);
        }
        if(!empty($filter['issue_date'])){
            $this->db->where('issue.issue_date', $filter['issue_date']);
        }
        if(!empty($filter['return_date'])){
            $this->db->where('issue.return_date', $filter['return_date']);
        }
        if(!empty($filter['renewal_date'])){
            $this->db->where('issue.renewal_date', $filter['renewal_date']);
        }
        if(!empty($filter['actual_return_date'])){
            $this->db->where('issue.actual_return_date', $filter['actual_return_date']);
        }
        if(!empty($filter['fine'])){
            $this->db->where('issue.fine', $filter['fine']);
        }
        if(!empty($filter['days_delayed'])){
            $this->db->where('issue.days_delayed', $filter['days_delayed']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('issue.remarks', $filter['remarks']);
        }
        $this->db->where('issue.user_type', 'staff');
    }
        $this->db->where('issue.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllIssuedBookInfo($filter, $page, $segment){
     
        
        $this->db->from('tbl_library_issue_info as issue'); 
       
        if($filter['user_type'] == 'student'){
            $this->db->select('issue.access_code, issue.isbn, issue.student_id,issue.row_id,issue.renewal_date,
            issue.issue_date, issue.return_date,issue.actual_return_date,student.student_name,library.book_title,
            issue.fine, issue.days_delayed, issue.remarks,issue.is_issued');

        $this->db->join('tbl_students_info as student','student.student_id = issue.student_id','left');
        $this->db->join('tbl_library_managemnt as library','library.access_code = issue.access_code','left');


        if(!empty($filter['access_code'])){
            $this->db->where('issue.access_code', $filter['access_code']);
        }
        if(!empty($filter['isbn'])){
            $this->db->where('issue.isbn', $filter['isbn']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('issue.student_id', $filter['student_id']);
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
        if(!empty($filter['book_title'])) {
            $like = "(library.book_title  LIKE '%".$filter['book_title']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['issue_date'])){
            $this->db->where('issue.issue_date', $filter['issue_date']);
        }
        if(!empty($filter['renewal_date'])){
            $this->db->where('issue.renewal_date', $filter['renewal_date']);
        }
        if(!empty($filter['return_date'])){
            $this->db->where('issue.return_date', $filter['return_date']);
        }
        if(!empty($filter['actual_return_date'])){
            $this->db->where('issue.actual_return_date', $filter['actual_return_date']);
        }
        if(!empty($filter['fine'])){
            $this->db->where('issue.fine', $filter['fine']);
        }
        if(!empty($filter['days_delayed'])){
            $this->db->where('issue.days_delayed', $filter['days_delayed']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('issue.remarks', $filter['remarks']);
        }
        $this->db->where_in('issue.user_type', ['student',' ']);
        
    }else{

        $this->db->select('issue.access_code, issue.isbn, issue.student_id,issue.row_id,issue.renewal_date,  
        issue.issue_date, issue.return_date,issue.actual_return_date,staff.name as student_name,library.book_title,
        issue.fine, issue.days_delayed, issue.remarks,issue.is_issued');
        $this->db->join('tbl_staff as staff','staff.staff_id = issue.student_id','left');
        $this->db->join('tbl_library_managemnt as library','library.access_code = issue.access_code','left');

        if(!empty($filter['access_code'])){
            $this->db->where('issue.access_code', $filter['access_code']);
        }
        if(!empty($filter['book_title'])) {
            $like = "(library.book_title  LIKE '%".$filter['book_title']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['isbn'])){
            $this->db->where('issue.isbn', $filter['isbn']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('issue.student_id', $filter['student_id']);
        }
       
        if(!empty($filter['student_name'])) {
            $like = "(staff.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['issue_date'])){
            $this->db->where('issue.issue_date', $filter['issue_date']);
        }
        if(!empty($filter['return_date'])){
            $this->db->where('issue.return_date', $filter['return_date']);
        }
        if(!empty($filter['renewal_date'])){
            $this->db->where('issue.renewal_date', $filter['renewal_date']);
        }
        if(!empty($filter['actual_return_date'])){
            $this->db->where('issue.actual_return_date', $filter['actual_return_date']);
        }
        if(!empty($filter['fine'])){
            $this->db->where('issue.fine', $filter['fine']);
        }
        if(!empty($filter['days_delayed'])){
            $this->db->where('issue.days_delayed', $filter['days_delayed']);
        }
        if(!empty($filter['remarks'])){
            $this->db->where('issue.remarks', $filter['remarks']);
        }
        $this->db->where('issue.user_type', 'staff');
    }
        $this->db->where('issue.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIssuedInfoById($row_id){
        $this->db->from('tbl_library_issue_info as issue'); 
        $this->db->where('issue.row_id', $row_id);
        $this->db->where('issue.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateBookIssuedInfo($row_id,$IssueInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_library_issue_info', $IssueInfo);
        return TRUE;
    }

    function getFineById($row_id){
        $this->db->from('tbl_library_fine as fine');
        $this->db->where('fine.row_id', $row_id);
        $this->db->where('fine.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function getTotalStudent(){
        $this->db->from('tbl_students_info as student'); 
        //$this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        //$this->db->where('academic.is_current', 1);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function getBowrrowedCount(){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.is_available', 0);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getTotalBooks(){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getTotalFine(){
        $this->db->select('SUM(issue.fine) as fine');
        $this->db->from('tbl_library_issue_info as issue'); 
        $this->db->where('issue.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fine;
    }

    function getAllAccessInfo(){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.is_available', 1);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getAccessData($access_code){
        $this->db->from('tbl_library_managemnt as library');
        $this->db->where('library.access_code', $access_code);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getCheckAccessCode($access_code){
        $this->db->from('tbl_library_managemnt as library'); 
        $this->db->where('library.access_code', $access_code);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function checkAccessNumberExists($access_code){
        $this->db->from('tbl_library_managemnt as library');
        $this->db->where('library.access_code', $access_code);
        $this->db->where('library.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getLastAccessId(){
        $this->db->select('library.access_code');
        $this->db->from('tbl_library_managemnt as library');
        $this->db->where('library.is_deleted', 0);
        $this->db->order_by('library.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row()->access_code;
    }


    public function getBookAccessNo($row_id){
        $this->db->select('mgmt.row_id,mgmt.category,mgmt.book_title,mgmt.author_name,mgmt.publisher_name,mgmt.access_code');
          $this->db->from('tbl_library_managemnt as mgmt'); 
          $this->db->where_in('mgmt.access_code', $row_id);
          $this->db->where('mgmt.is_deleted', 0);
         // $this->db->order_by('student.register_no', 'ASC');
          $query = $this->db->get();
          return $query->row();
      }

}
?>