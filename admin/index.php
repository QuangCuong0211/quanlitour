<?php
    ob_start();
    session_start();
    if(!isset($_SESSION['user_admin'])) {
        header("Location: login.php");
        exit();
    }
    require_once "models_admin/pdo_library.php";
    require_once "models_admin/BaseModel.php";
    require_once "models_admin/CategoryModel.php";
    require_once "models_admin/ProductModel.php";
    require_once "models_admin/CustomerModel.php";
    require_once "models_admin/OrderModel.php";
    require_once "models_admin/PostModel.php";
    require_once "models_admin/CommentModel.php";
    require_once "models_admin/WarehousemModel.php";

    require_once "components/head.php";
    require_once "components/header.php";
    
    

    if(!isset($_GET['quanli'])) {
        require_once "home.php";
    }else {
        switch ($_GET['quanli']) {
            case 'danh-sach-san-pham':
                require_once "san-pham/list.php";         
                break;
            case 'them-san-pham':
                         
                require_once "san-pham/add.php";   
                break;
            case 'cap-nhat-san-pham':
                require_once "san-pham/edit.php";   
                break;
            case 'thung-rac-san-pham':
                require_once "san-pham/recycle-bin.php";   
                break;
            // Danh mục
            case 'danh-sach-danh-muc':
                
                require_once "danh-muc/list.php";         
                break;
            case 'them-danh-muc':
                         
                require_once "danh-muc/add.php";   
                break;
            case 'cap-nhat-danh-muc':
                
                require_once "danh-muc/edit.php";   
                
                break;
            // Đơn hàng    
            
            case 'danh-sach-don-hang':

                require_once "don-hang/list.php";         
                break;
            case 'danh-sach-don-cho':

                require_once "don-hang/unconfirmed.php";         
                break;
            case 'cap-nhat-don-hang':

                require_once "don-hang/edit.php";         
                break;
            case 'in-hoa-don':
                require_once "don-hang/hoadon.php";
                break;     
            // Bài viết
            case 'danh-sach-bai-viet':

                require_once "bai-viet/list.php";         
                break;
            case 'them-bai-viet':

                require_once "bai-viet/add.php";         
                break;
            case 'cap-nhat-bai-viet':
                require_once "bai-viet/edit.php";         
                break;    
            case 'danh-muc-bai-viet':

                require_once "bai-viet/category.php";         
                break;
            case 'cap-nhat-danh-muc-bai-viet':

                require_once "bai-viet/edit_catgory.php";         
                break;
            //Tài khoản
            case 'dang-xuat':
                unset($_SESSION['user_admin']);
                header("Location: login.php");
                break;
                
            
            // Quản lí nhân viên và khách hàng
            //Nhân viên
            case 'danh-sach-nhan-vien':

                require_once "thanh-vien/list_nv.php";         
                break; 
            case 'them-tai-khoan-nv':
                require_once "thanh-vien/add_nv.php";         
                break;
            case 'sua-tai-khoan-nv':
                require_once "thanh-vien/edit_nv.php";         
                break;


            //Khách hàng
            case 'danh-sach-khach-hang':

                require_once "thanh-vien/list_kh.php";         
                break; 
            case 'them-tai-khoan-kh':
                require_once "thanh-vien/add_kh.php";         
                break;
            case 'sua-tai-khoan-kh':
                require_once "thanh-vien/edit_kh.php";         
                break;      
            
            // Bình luận  
            case 'binh-luan':
                require_once "binh-luan/list.php";         
                break; 
            case 'chi-tiet-binh-luan':
                require_once "binh-luan/edit.php";         
                break;
            // Thống kê  
            case 'thong-ke-san-pham':
                require_once "thong-ke/products.php";         
                break; 
            case 'thong-ke-don-hang':
                require_once "thong-ke/orders.php";         
                break;
            case 'bieu-do-luot-ban':
                require_once "thong-ke/chart-order.php";         
                break;
            case 'top-luot-ban':
                require_once "thong-ke/top-orders.php";         
                break;
            case 'luot-ban-theo-ngay':
                require_once "thong-ke/chart-order-date.php";         
                break;
            case 'xuat-exel':
                require_once "export_exel/export_orders.php";         
                break;
            case 'kho-hang2':
                require_once "kho-hang/list.php";         
                break;
            case 'kho-hang':
                require_once "kho-hang/danhsach.php";         
                break;
            case 'them-hoa-don':
                require_once "kho-hang/add.php";         
                break;
            

            default:
                require_once "components/404.php";
                break;
        }
    }

    require_once "components/footer.php";


    
    ob_end_flush();
?>