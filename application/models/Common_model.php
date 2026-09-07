<?php defined("BASEPATH") or exit("No Direct Access Allowed!");

class Common_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();

    }
    public function insert_new($data = array()){ 
        $insert = $this->db->insert_batch('upload',$data); 
        return $insert?true:false; 
    }
    public function insert_news($data = array()){ 
        $insert = $this->db->insert_batch('servupload',$data); 
        return $insert?true:false; 
    }
    public function countAll(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function searchlist($keyword)
    {
        $this->db->select('product.id,product.title,product.name,product.status');
        $this->db->from('product');
        $this->db->like('product.name', $keyword, 'both');
        $this->db->where(array('product', 'status' => 'Active'));
        return $this->db->get()->result_array();
    }
    private function _get_datatables_query($postData){
        $this->db->from($this->table);
        $i = 0;
        foreach($this->column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function insert($data = array())
    {
        $insert = $this->db->insert_batch('upload', $data);
        return $insert ? true : false;
    }
    public function getAll($table, $orderby = null, $where = null, $keys = null, $limit = null, $start = null, $groupby = null, $distinct = null)
    {
        if (!is_null($keys)) {
            $this->db->select($keys);
        }
        if (!is_null($distinct)) {
            $this->db->distinct();
        }
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        if (!is_null($orderby)) {
            $this->db->order_by($orderby);
        }
        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($groupby)) {$this->db->group_by($groupby);}

        return $this->db->get($table)->result_array();
    }

    public function getSingle($table, $where = null, $keys = null, $orderby = null, $limit = null, $inkey = null, $invalue = null)
    {
        if (!is_null($keys)) {
            $keys = trim($keys);
        } else { $keys = '*';}
        $this->db->select($keys);

        if (!is_null($limit)) {
            $this->db->limit($limit);
        }
        if (!is_null($orderby)) {
            $this->db->order_by($orderby);
        }
        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($inkey) && !is_null($invalue) && !empty($inkey) && !empty($invalue)) {
            $query = $this->db->where_in($inkey, (explode(',', $invalue)));
        }

        return $this->db->get($table)->row_array();

    }

    public function getRow($table, $where = null, $keys = null, $orderby = null, $limit = null, $inkey = null, $invalue = null)
    {
        if (!is_null($keys)) {
            $keys = trim($keys);
        } else { $keys = '*';}
        $this->db->select($keys);

        if (!is_null($limit)) {
            $this->db->limit($limit);
        }
        if (!is_null($orderby)) {
            $this->db->order_by($orderby);
        }
        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($inkey) && !is_null($invalue) && !empty($inkey) && !empty($invalue)) {
            $query = $this->db->where_in($inkey, (explode(',', $invalue)));
        }

        if (strpos($keys, ',') !== false) {
            return $this->db->get($table)->row_array();
        } else if (strpos($keys, '*') !== false) {
            return $this->db->get($table)->row_array();
        } else {
            $rows = $this->db->get($table)->row_array();
            return $rows[$keys];
        }

    }

    public function getcolumn($table, $where, $key, $orderby = null, $limit = null)
    {
        if (!is_null($key)) {
            $this->db->select($key);
        }
        if (!is_null($limit)) {
            $this->db->limit($limit);
        }
        if (!is_null($orderby)) {
            $this->db->order_by($orderby);
        }
        $data = $this->db->where($where)->get($table)->row_array();
        return $data[$key];
    }

    public function delete($table, $where)
    {
        return $this->db->where($where)->delete($table);
    }

    public function countitem($table, $where = null, $whereor = null, $whereorkey = null, $groupby = null)
    {

        if (!is_null($where)) {

            $query = $this->db->where($where);

            if (!is_null($whereor)) {
                $query = $this->db->group_start();
                foreach ($whereor as $row) {$query = $this->db->or_where($whereorkey, $row);}
                $query = $this->db->group_end();
            }
            if (!is_null($groupby)) {$this->db->group_by($groupby);}
            $query = $this->db->get($table);
        } else { $query = $this->db->get($table);}
        $count = $query->num_rows();
        return ($count > 0 ? $count : 0);
    }

    public function saveupdate($table, $dataarray, $validation = null, $where = null, $id = null)
    {

        if (!is_null($where)) {
            $status = $this->db->where($where)->update($table, $dataarray);
            return !is_null($id) ? $id : $status;
        } else {

            if (!is_null($validation)) {
                $this->db->where($validation);
            }

            if (!is_null($validation) && $this->db->get($table)->num_rows() > 0) {
                return false;
            } else {
                $this->db->insert($table, $dataarray);
                return $this->db->insert_id();
            }
        }

    }

    public function save($table, $dataarray, $validation = null, $where = null, $id = null)
    {

        if (!is_null($where)) {
            $status = $this->db->where($where)->update($table, $dataarray);
            return !is_null($id) ? $id : $status;
        } else {

            if (!is_null($validation)) {
                $this->db->where($validation);
            }

            if (!is_null($validation) && $this->db->get($table)->num_rows() > 0) {
                return false;
            } else {
                $this->db->insert($table, $dataarray);
                return $this->db->insert_id();
            }
        }

    }
    public function getfilter($tablename, $wherearray = null, $limit = null, $start = null, $orderby = null, $orderbykey = null, $whereor = null, $whereorkey = null, $like = null, $likekey = null, $getorcount = null, $infield = null, $invalue = null, $keys = null, $groupby = null)
    {

        if (!is_null($keys)) {$this->db->distinct();
            $this->db->select($keys);}
        if (!is_null($groupby)) {$this->db->group_by($groupby);}

        if (!is_null($limit) && !is_null($start) && $start > 0 && $limit > 0) {

            if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {$query = $this->db->order_by($orderbykey, $orderby);}

            if (!is_null($likekey) && !is_null($like)) {$this->db->like($likekey, $like, 'both');}

            $query = $this->db->limit($limit, $start);
            if (!is_null($whereor) && !is_null($whereorkey)) {
                $query = $this->db->group_start();
                foreach ($whereor as $row) {$query = $this->db->or_where($whereorkey, $row);}
                $query = $this->db->group_end();
            }

            if (!is_null($whereor) && !is_null($whereorkey) && !empty($whereand)) {
                $query = $this->db->group_start();
                foreach ($whereand as $datet) {$query = $this->db->or_where($whereorkey, $datet);}
                $query = $this->db->group_end();
            }

            if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
                $query = $this->db->where_in($infield, (explode(',', $invalue)));
            }
            if (!is_null($wherearray)) {$query = $this->db->where($wherearray);}
            $query = $this->db->get($tablename);
        } else if (!is_null($limit) && $limit > 0) {

            if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {$query = $this->db->order_by($orderbykey, $orderby);}

            if (!is_null($likekey) && !is_null($like)) {$this->db->like($likekey, $like, 'both');}
            $query = $this->db->limit($limit);
            if (!is_null($whereor) && !is_null($whereorkey)) {
                $query = $this->db->group_start();
                foreach ($whereor as $row) {$query = $this->db->or_where($whereorkey, $row);}
                $query = $this->db->group_end();
            }

            if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
                $query = $this->db->where_in($infield, (explode(',', $invalue)));
            }
            if (!is_null($wherearray)) {$query = $this->db->where($wherearray);}
            $query = $this->db->get($tablename);

        } else {
            if (!is_null($orderby) && ($orderby == 'ASC' || $orderby == 'DESC')) {$query = $this->db->order_by('id', $orderby);}

            if (!is_null($likekey) && !is_null($like)) {$this->db->like($likekey, $like, 'both');}

            if (!is_null($whereor) && !is_null($whereorkey)) {
                $query = $this->db->group_start();
                foreach ($whereor as $row) {$query = $this->db->or_where($whereorkey, $row);}
                $query = $this->db->group_end();
            }

            if (!is_null($infield) && !is_null($invalue) && !empty($infield) && !empty($invalue)) {
                $query = $this->db->where_in($infield, (explode(',', $invalue)));
            }
            if (!is_null($wherearray)) {$query = $this->db->where($wherearray);}
            $query = $this->db->get($tablename);
        }

        $output = ($getorcount == 'count') && !is_null($getorcount) ? $query->num_rows() : $query->result_array();

        return $output ? $output : '';
    }
    public function dataTables($table,$orderby,$groupby,$where)
    {
       


        // $this->table = 'dt_members';
        // $this->column_order = array('id','first_name','last_name','email','gender','country','created','status');
        // $this->column_search = array('id','first_name','last_name','email','gender','country','created','status');
        // $this->order = array('id' => 'asc');
    }
    
    public function allorder()
    {
        $this->db->select('*');
        $this->db->order_by('id DESC');
        $this->db->where('id !=', '');
        return $this->db->get('orders')->result_array();
    }
    public function saveContact($formArray)
    {
        $this->db->insert('contact', $formArray);
    }
    public function savepdf($formArray)
    {
        $this->db->insert('cv', $formArray);
    }
    public function getUser($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('subProducts')->row_array();
    }
}
