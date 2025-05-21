## Clone code về : 
```
git clone https://github.com/ZuuYeuDoi/wd35_su25.git
```

## Chạy lệnh: 
```
composer install
```

## Tạo file .env và coppy các biến từ .env.example qua

## Git:

```
1. Áp dụng chuẩn quy tắc git flow, git convention
/-----\
- Nhánh main chứa code hoàn thiện, sau khi trải qua test oke
- Các thành viên sau khi clone về tự checkout nhánh riêng code độc lập
- Chỉ merge vào nhánh main khi trưởng nhóm đồng ý

/-----\
--- <type>[optional scope]: <description>
-Feat: tạo 1 nhánh feature mới hoàn toàn và code trong nhánh đó.
-Fix: áp dụng khi bạn thay đổi code trên một đoạn code hay một file code đã tồn tại.
-Docs: Thay đổi trong file liên quan đến đuôi .md
-Style: Thay đổi lại nhưng không ảnh hưởng đến code (vd : formatting ).
-Refactor: Là những thay đổi cấu trúc lại code và không thay đổi gì trong code hay thêm feature mới.(VD: cấu trúc lại 1 đoạn code có sẵn)
-Perf: (performance) Thay đổi mã giúp cải thiện hiệu suất. (VD: giảm thời gian query)
-Test: Thêm các tính năng kiểm thử trong code. (VD: thêm các Testcase liên quan đến hàm)
-Chore: Là những thay đổi không liên quan đến source code hay test

Ví Dụ:

git commit -m "feat(lang): added vietnamese language"

```
