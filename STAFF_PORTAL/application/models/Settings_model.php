<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings_model extends CI_Model{
    //getting shift info
    public function getAllShiftInfo(){
        $this->db->from('tbl_staff_shift_info as shift');
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting department Info
    public function getAllDepartmentInfo(){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept.is_deleted', 0);
        $this->db->order_by('dept.dept_id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    //getting category info
    public function getAllCategoryInfo(){
        $this->db->from('tbl_category as category');
        $this->db->where('category.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    //getting religion info
    public function getAllReligionInfo(){
        $this->db->from('tbl_religion_details as religion');
        $this->db->where('religion.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting cast info
    public function getAllCasteInfo(){
        $this->db->from('tbl_caste_details as caste');
        $this->db->where('caste.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //getting nationality info
    public function getAllNationalityInfo(){
        $this->db->from('tbl_nationality as nationality');
        $this->db->where('nationality.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    /* This function is used to add department */
    public function addDepartment($departmentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_department', $departmentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
     /**
     * This function is used to add college details
     */
    public function addReligion($religionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_religion_details', $religionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
   /**
     * This function is used to add college details
     */
    public function addCaste($castInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_caste_details', $castInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function checkCasteExists($caste_name){
        $this->db->from('tbl_caste_details as caste');
        $this->db->where('name', $caste_name);
        $this->db->where('caste.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

     /**
     * This function is used to add nationalityInfo details
     */
    public function addNationality($nationalityInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_nationality', $nationalityInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

     /**
     * This function is used to add category  details
     */
    public function addCategory($categoryInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_category', $categoryInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateReligion($religionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_religion_details', $religionInfo);
        return TRUE;
    }

    
    public function updateCaste($casteInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_caste_details', $casteInfo);
        return TRUE;
    }

    public function updateNationality($nationalityInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_nationality', $nationalityInfo);
        return TRUE;
    }

    public function updateCategory($categoryInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_category', $categoryInfo);
        return TRUE;
    }
    public function updateDepartment($deptInfo, $row_id){
        $this->db->where('id', $row_id);
        $this->db->update('tbl_department', $deptInfo);
        return TRUE;
    }

    public function checkDeptIdExists($dept_id){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept_id', $dept_id);
        $this->db->where('dept.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStreamInfo(){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->where('stream.is_deleted', 0);
        // $this->db->order_by('stream.term_name','asc');
        // $this->db->order_by('stream.stream_name','asc');
        $query = $this->db->get();
        return $query->result();
    }
    public function getDistinctStreamInfo(){
        $this->db->from('tbl_stream_info as stream');
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('stream.row_id','asc');
        $this->db->group_by('stream.stream_name');
        $query = $this->db->get();
        return $query->result();
    }

    function addSection($sectionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_section_info', $sectionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getSectionInfo($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,section.class_type,
        section.class_teacher,staff.staff_id,staff.name,section.term_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = section.class_teacher','left'); 
        if(!empty($filter['by_term'])){
            $this->db->where('section.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('stream.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_section'])){
            $this->db->where('section.section_name', $filter['by_section']);
        }
        if(!empty($filter['by_class_type'])){
            $this->db->where('section.class_type', $filter['by_class_type']);
        }
        if(!empty($filter['by_class_teacher'])){
            $this->db->where('staff.staff_id', $filter['by_class_teacher']);
        }
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('section.term_name','asc');
        $this->db->order_by('stream.row_id','asc');
        $query = $this->db->get();
        return $query->result();
    }
    function updateSection($sectionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_section_info', $sectionInfo);
        return TRUE;
    }
    function checkSectionExists($section,$stream_id,$term_name) {
        $this->db->from('tbl_section_info as section');
        $this->db->where('section.stream_id', $stream_id);
        $this->db->where('section.section_name', $section);
        $this->db->where('section.term_name', $term_name);
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // class timings
    public function addTimings($classInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_class_timings', $classInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function checkClassTimingsExists($start_time,$end_time,$week_id) {
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
        $this->db->where('class.start_time', $start_time);
        $this->db->where('class.end_time', $end_time);
        $this->db->where('class.week_row_id', $week_id);
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // get all class timings
    public function getAllClassTimingsInfo(){
        $this->db->select('class.row_id,week.row_id as week_id,class.start_time,class.end_time,week.week_name');
        $this->db->from('tbl_class_timings as class');
        $this->db->join('tbl_weekname as week', 'week.row_id = class.week_row_id','left');
        $this->db->where('class.is_deleted', 0);
        $this->db->where('week.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateClassTimings($classInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_class_timings', $classInfo);
        return TRUE;
    }

    
    // time table shifting info
    public function addDayShiftingInfo($shiftingInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_timetable_day_shifting', $shiftingInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllTimetableDayShiftingInfo() {
        $this->db->select('shift.row_id,week.week_name,shift.date,shift.week_id');
        $this->db->from('tbl_timetable_day_shifting as shift');
        $this->db->join('tbl_weekname as week', 'week.row_id = shift.week_id');
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function updateTimetableDayShift($shiftInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_timetable_day_shifting', $shiftInfo);
        return TRUE;
    }
    function checkTimetableShiftingExists($week_id,$date) {
        $this->db->from('tbl_timetable_day_shifting as shift');
        $this->db->where('shift.week_id', $week_id);
        $this->db->where('shift.date', $date);
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

       // class timings
       public function addFeesName($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fees_name', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    function checkFeeNameExists($fee_name) {
        $this->db->from('tbl_fees_name as fee');
        $this->db->where('fee.fee_name', $fee_name);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // get all class timings
    public function getAllFeeNameInfo(){
        $this->db->from('tbl_fees_name as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateFeeNameInfo($feeInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_fees_name', $feeInfo);
        return TRUE;
    }

    

    // election Details
    public function updatePost($postInfo, $post_id){
        $this->db->where('post_id', $post_id);
        $this->db->update('tbl_student_election_post_info', $postInfo);
        return TRUE;

    }
    public function addPost($postInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_student_election_post_info', $postInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllPostInfo(){
        $this->db->from('tbl_student_election_post_info as post');
        $this->db->where('post.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // fee type
    public function updateFeeType($feeInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_fee_structure_type', $feeInfo);
        return TRUE;

    }
    public function addFeeType($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fee_structure_type', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAllFeeTypeInfo(){
        $this->db->from('tbl_fee_structure_type as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function addRelegionInfo($relInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_religion_info', $relInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updatedStudentInfo($student_info,$student_id){
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_students_info', $student_info);
        return TRUE;
    }

      public function addBookInfo($libraryInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_library_managemnt',$libraryInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateBook($libraryInfo,$access_code){
        $this->db->where('access_code', $access_code);
        $this->db->update('tbl_library_managemnt',$libraryInfo);
        return TRUE;
    }

    public function addRemarkName($remarkInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_remarks_type', $remarkInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getRemarkNameInfo()
    {
        $this->db->from('tbl_student_remarks_type as remark');
        $this->db->where('remark.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    function deleteRemarkName($remarkInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_remarks_type', $remarkInfo);
        return TRUE;
    }

    public function addMiscellaneousType($miscellaneousInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_miscellaneous_type', $miscellaneousInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getAllMiscellaneousTypeInfo(){
        $this->db->from('tbl_miscellaneous_type as fee');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateMiscellaneousType($miscellaneousInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_miscellaneous_type', $miscellaneousInfo);
        return TRUE;

    }

    public function getStudentByStudentId($student_id){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name,student.elective_sub');
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function checkmarkExists($student_id, $subject_code,$exam_type,$year) {
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id',$student_id);
        $this->db->where('exam.subject_code',$subject_code);
        $this->db->where('exam.exam_type','ANNUAL_IMPORT');
        $this->db->where('exam.exam_year','2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addMarkInfo($info) {
        $this->db->trans_start();
        $this->db->insert('tbl_college_internal_exam_marks', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateStudentInfo($acInfo, $register_no){
        $this->db->where('student_id', $register_no);
        $this->db->update('tbl_students_info', $acInfo);
        return TRUE;
    }

    public function getAllDocumentTypeInfo() {
        $this->db->from('tbl_document_type_info as doc');
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function checkDocNameExists($doc_name) {
        $this->db->from('tbl_document_type_info as doc');
        $this->db->where('doc.document_name', $doc_name);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addDocName($villageInfo) {

        $this->db->trans_start();

        $this->db->insert('tbl_document_type_info', $villageInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;

    }

    public function updateDocumentType($categoryInfo, $row_id) {

        $this->db->where('row_id', $row_id);

        $this->db->update('tbl_document_type_info', $categoryInfo);

        return TRUE;

    }

}