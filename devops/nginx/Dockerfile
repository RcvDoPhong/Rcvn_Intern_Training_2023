# Sử dụng image nginx:1.19-alpine
FROM nginx:1.25-alpine

# Copy toàn bộ nội dung ở trong default.conf vào file default.conf trong container
ADD ./devops/nginx/default.conf /etc/nginx/conf.d/default.conf

# Tạo thư mục /var/www
RUN mkdir -p /var/www
