document.addEventListener('DOMContentLoaded', function() {
    // Xử lý chuyển đổi tab
    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.content-section');

    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Xóa class active từ tất cả menu items
            menuItems.forEach(mi => mi.classList.remove('active'));
            
            // Thêm class active cho menu item được click
            this.classList.add('active');
            
            // Ẩn tất cả content sections
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Hiển thị content section tương ứng
            const targetId = this.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('active');
        });
    });

    // Xử lý form thông tin cá nhân
    const profileForm = document.querySelector('.profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu từ form
            const formData = new FormData(this);
            
            // Gửi dữ liệu lên server (cần thêm API endpoint)
            // fetch('/api/update-profile', {
            //     method: 'POST',
            //     body: formData
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         showNotification('Cập nhật thông tin thành công!', 'success');
            //     } else {
            //         showNotification('Có lỗi xảy ra!', 'error');
            //     }
            // })
            // .catch(error => {
            //     showNotification('Có lỗi xảy ra!', 'error');
            // });

            // Tạm thời hiển thị thông báo thành công
            showNotification('Cập nhật thông tin thành công!', 'success');
        });
    }

    // Hàm hiển thị thông báo
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Hiển thị thông báo
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Ẩn thông báo sau 3 giây
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
}); 