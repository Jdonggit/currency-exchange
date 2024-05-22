# 匯率轉換 API

env放上來方便測試
1. 建立image `docker build -t=exchange . `
2. run image `docker run -d --name exchange -p 8080:80 exchange   `
3. 測試 API http://localhost:8080/api/exchange?source=USD&target=JPY&amount=1,525.00
