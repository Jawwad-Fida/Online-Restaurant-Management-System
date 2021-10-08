<?php

class OrderTransaction
{

    public function getRecordQuery($tran_id)
    {
        $sql = "select * from orders WHERE transaction_id='" . $tran_id . "'";
        return $sql;
    }
    public function saveTransactionQuery($post_data)
    {
        $name = $post_data['cus_name'];
        $cus_id = $post_data['cus_id'];
        $email = $post_data['cus_email'];
        //$phone = $post_data['cus_phone'];
        $item_amount = $post_data['total_amount'];

        //$address = $post_data['cus_add1'];
        //$city = $post_data['cus_city'];
        $transaction_id = $post_data['tran_id'];
        //$zip_code = $post_data['cus_zip'];
        $quantity = $post_data['cus_items'];
        $order_date = $post_data['ship_date'];

        $delivery_status = "Not Assigned";
        $order_pin_code = $post_data['cus_order_pin'];
        $identify_num = $post_data['cus_order_identify'];
        $status = "Pending"; //must 

        $vat = $post_data['vat'];
        $discount_amount = $post_data['discount_amount'];
        $delivery_charge = $post_data['delivery_charge'];
        $total_amount = $item_amount + $vat + $delivery_charge - $discount_amount;

        //Insert data into orders table
        $sql = "INSERT INTO orders(identify_num,cus_id,cus_name,cus_email,order_date,order_pin_code,total_amount,total_quantity,status,transaction_id,delivery_status) 
        VALUES('$identify_num',$cus_id,'$name','$email','$order_date','$order_pin_code',$total_amount,$quantity,'$status','$transaction_id','$delivery_status')";

        return $sql;
    }

    public function updateTransactionQuery($tran_id, $type = 'Success')
    {
        $sql = "UPDATE orders SET status='$type' WHERE transaction_id='$tran_id'";

        return $sql;
    }
}
