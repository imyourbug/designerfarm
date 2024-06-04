let ws;
let loggedInUserID;

window.onload = function () {
  // Lấy thông tin đăng nhập từ localStorage
  const storedUserID = localStorage.getItem('loggedInUserID');
  if (storedUserID) {
    loggedInUserID = storedUserID;
    Refesh(loggedInUserID);
  }
};

function Refesh(userID) {
  const inputUserID = userID || document.getElementById('userIDInput').value;
  const loginButton = document.getElementById('userDropdown');
  //loginButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
  //loginButton.disabled = true;

    // Tạo URL để gửi yêu cầu đến API kiểm tra thông tin người dùng
  const url = "https://s4.khobanquyen.net/user.php";
  // Tạo body cho request
  const body = new FormData();
  body.append('view', true);
  body.append('userId_to_view', inputUserID);

  // Tạo options cho fetch
  const options = {
    method: 'POST',
    body: body
  };

  // Gửi yêu cầu đến API
  fetch(url, options)
    .then(response => response.json())
    .then(data => {
      // Kiểm tra nếu thông tin trả về là "Member invalid"
      if (data.hasOwnProperty('error') && data.error === "Member invalid") {
        // Hiển thị thông báo cho người dùng rằng user chưa được đăng kí
        logout();
      } else {
        // Hiển thị thông tin cụ thể của người dùng
        dataLG(JSON.stringify(data));
        
          ws = new WebSocket(
        (location.protocol === 'https:' ? 'wss://' : 'ws://') +
        window.location.host
      );
    
      ws.onopen = function () {
        const loginMessage = `Login:${inputUserID}`;
        ws.send(JSON.stringify({ type: 'connect', userID: inputUserID }));
      };
    
      ws.onmessage = function (event) {
    const data = JSON.parse(event.data);
    if (data.type === 'connected') {
      // Không làm gì khi kết nối thành công
    } else if (data.type === 'message') {
        const notificationText = document.getElementById('notification');
        notificationText.style.display = 'block';
        // Kiểm tra xem data.content có phải là URL không
        const urlPattern = /^(https?:\/\/)?([\w\d]+\.)?[\w\d]+\.\w+(\/[\w\d]+)*/i;
        if (urlPattern.test(data.content)) {
          // Chờ 1 giây trước khi mở URL trong tab mới
          setTimeout(function () {
            window.open(data.content, '_blank');
          }, 1000);
  
          // Hiển thị thông báo với liên kết
          notificationText.innerHTML = "<a href='" + data.content + "' target='_blank'>Bạn có thể tải lại file tại đây!</a>";
        } else {
          // Hiển thị thông báo văn bản
          handleOtherResponse(data.content);
        }
    }
  };
      }
    })
    .catch(error => console.error('Error:', error));
    

}

function connectWebSocket(userID) {
  const inputUserID = userID || document.getElementById('userIDInput').value;
  const loginButton = document.getElementById('userDropdown');
  loginButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
  loginButton.disabled = true;

  ws = new WebSocket(
    (location.protocol === 'https:' ? 'wss://' : 'ws://') +
    window.location.host
  );

  ws.onopen = function () {
    const loginMessage = `Login:${inputUserID}`;
    ws.send(JSON.stringify({ type: 'connect', userID: inputUserID }));
    ws.send(JSON.stringify({ type: 'message', content: loginMessage, receiverID: 'Login' }));
  };

  ws.onmessage = function (event) {
    const data = JSON.parse(event.data);
    if (data.type === 'connected') {
      // Không làm gì khi kết nối thành công
    } else if (data.type === 'message') {
      const notificationText = document.getElementById('notification');
      notificationText.style.display = 'block';

      if (data.content.startsWith('Success:')) {
        document.getElementById('notification').innerText = 'Đăng nhập thành công';
        handleSuccessResponse(data.content);
        // Lưu thông tin đăng nhập vào localStorage
        localStorage.setItem('loggedInUserID', inputUserID);
      } else if (data.content === 'False') {
        handleFalseResponse();
      } else {
        // Kiểm tra xem data.content có phải là URL không
        const urlPattern = /^(https?:\/\/)?([\w\d]+\.)?[\w\d]+\.\w+(\/[\w\d]+)*/i;
        if (urlPattern.test(data.content)) {
          // Chờ 1 giây trước khi mở URL trong tab mới
          setTimeout(function () {
            window.open(data.content, '_blank');
          }, 1000);
  
          // Hiển thị thông báo với liên kết
          notificationText.innerHTML = "<a href='" + data.content + "' target='_blank'>Bạn có thể tải lại file tại đây!</a>";
        } else {
          // Hiển thị thông báo văn bản
          handleOtherResponse(data.content);
        }
      }
    }
  };
}

function handleSuccessResponse(content) {
  const userInfo = content.split(': ')[1];
  const userInfoArray = userInfo.split(',');

  // Cập nhật giá trị của nút dropdown thành userID của người dùng
  document.getElementById('userInfoBtn').innerText = userInfoArray[0];

  // Cập nhật giá trị của các link trong dropdown
  const limitFileIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="-49 141 512 512" width="16" height="16" aria-hidden="true" class="_24ydrq0 _1286nb11sr _1286nb11h9 _1286nb11m _1286nb12q9"><path d="M438 403c-13.808 0-25 11.193-25 25v134c0 19.299-15.701 35-35 35H36c-19.299 0-35-15.701-35-35V428c0-13.807-11.193-25-25-25s-25 11.193-25 25v134c0 46.869 38.131 85 85 85h342c46.869 0 85-38.131 85-85V428c0-13.807-11.192-25-25-25"></path><path d="M189.322 530.678a25.004 25.004 0 0 0 35.356 0l84.853-84.853c9.763-9.763 9.763-25.592 0-35.355s-25.592-9.763-35.355 0L232 452.645V172c0-13.807-11.193-25-25-25s-25 11.193-25 25v280.645l-42.175-42.175c-9.764-9.763-25.592-9.763-35.355 0s-9.763 25.592 0 35.355z"></path></svg>';
  const downloadIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4H0l10-9 10 9h-3zm-7-3V3h4v9h5l-7 6-7-6h5z"/></svg>';

  document.getElementById('packageTimeLink').innerHTML = `
  <div id="packageTimeLinkStatic" class="column-static">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" aria-hidden="true" class="clock-icon">
      <path d="M256 24C141.308 24 48 117.308 48 232s93.308 208 208 208 208-93.308 208-208S370.692 24 256 24zm0 376c-88.366 0-160-71.634-160-160s71.634-160 160-160 160 71.634 160 160-71.634 160-160 160zm64-232H252a12 12 0 0 0-12 12v132a12 12 0 0 0 3.76 8.764l96 72a12 12 0 0 0 16.24-1.53 12 12 0 0 0-1.52-16.24l-88-66V180a12 12 0 0 0-12-12z"></path>
    </svg>
    TIME
  </div>
  <div id="packageTimeLinkDynamic" class="column-dynamic">
    ${userInfoArray[2]}
  </div>`;
  //document.getElementById('filesDownloadedLink').innerHTML = `${limitFileIcon} DOWNLOADS ${userInfoArray[3]}/${userInfoArray[1]}`;
    document.getElementById('filesDownloadedLink').innerHTML = `
  <div id="filesDownloadedLinkStatic" class="column-static">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="-49 141 512 512" width="16" height="16" aria-hidden="true" class="_24ydrq0 _1286nb11sr _1286nb11h9 _1286nb11m _1286nb12q9">
      <path d="M438 403c-13.808 0-25 11.193-25 25v134c0 19.299-15.701 35-35 35H36c-19.299 0-35-15.701-35-35V428c0-13.807-11.193-25-25-25s-25 11.193-25 25v134c0 46.869 38.131 85 85 85h342c46.869 0 85-38.131 85-85V428c0-13.807-11.192-25-25-25"></path>
      <path d="M189.322 530.678a25.004 25.004 0 0 0 35.356 0l84.853-84.853c9.763-9.763 9.763-25.592 0-35.355s-25.592-9.763-35.355 0L232 452.645V172c0-13.807-11.193-25-25-25s-25 11.193-25 25v280.645l-42.175-42.175c-9.764-9.763-25.592-9.763-35.355 0s-9.763 25.592 0 35.355z"></path>
    </svg>
    DOWNLOADS
  </div>
  <div id="filesDownloadedLinkDynamic" class="column-dynamic">
    ${userInfoArray[3]}/${userInfoArray[1]}
  </div>`;
  // Ẩn button Đăng nhập
  document.getElementById('userDropdownLi').style.display = 'none';
  // Hiện dropdown thông tin người dùng
  document.getElementById('userInfoLi').style.display = 'block';
}




function toggleDropdown() {
  document.getElementById("userInfoDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

function handleFalseResponse() {
  const notificationText = document.getElementById('notification');
  notificationText.innerText = 'User ID chưa đăng ký!';
}

function handleOtherResponse(content) {
  const notificationText = document.getElementById('notification');
  notificationText.innerText = content;
}

function logout() {
  // Đóng kết nối WebSocket và reset UI
  if (ws && ws.readyState === WebSocket.OPEN) {
    ws.close();
  }
  document.getElementById('userInfoLi').style.display = 'none';
  document.getElementById('userDropdownLi').style.display = 'block';
  // Xóa thông tin đăng nhập từ localStorage khi đăng xuất
  localStorage.removeItem('loggedInUserID');
  
  // Làm mới lại trang sau 1 giây
  setTimeout(function() {
    location.reload();
  }, 1000);
}

// Hàm JavaScript mới để kiểm tra sự tồn tại của người dùng
function Login() {
  // Lấy ID của người dùng từ input
  const userId = document.getElementById('userIDInput').value;
  const notificationText = document.getElementById('notification');
  // Tạo URL để gửi yêu cầu đến API kiểm tra thông tin người dùng
  const url = "https://s4.khobanquyen.net/login.php";
  notificationText.style.display = 'block';
  // Tạo body cho request
  const body = new FormData();
  body.append('view', true);
  body.append('userId_to_view', userId);

  // Tạo options cho fetch
  const options = {
    method: 'POST',
    body: body
  };

  // Gửi yêu cầu đến API
  fetch(url, options)
    .then(response => response.json())
    .then(data => {
      // Kiểm tra nếu thông tin trả về là "Member invalid"
      if (data.hasOwnProperty('error') && data.error === "Member invalid") {
        // Hiển thị thông báo cho người dùng rằng user chưa được đăng kí
        handleFalseResponse();
      } else {
        document.getElementById('notification').innerText = 'Đăng nhập thành công';
        // Hiển thị thông tin cụ thể của người dùng
        dataLG(JSON.stringify(data));
      }
    })
    .catch(error => console.error('Error:', error));
}


function dataLG(content) {
  // Chuyển đổi nội dung trả về thành đối tượng JSON
  const userInfo = JSON.parse(content);

  // Cập nhật giá trị của nút dropdown thành userID của người dùng
  document.getElementById('userInfoBtn').innerText = userInfo.userId;

  document.getElementById('packageTimeLink').innerHTML = `
  <div id="packageTimeLinkStatic" class="column-static">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20" aria-hidden="true" class="clock-icon">
      <path d="M256 24C141.308 24 48 117.308 48 232s93.308 208 208 208 208-93.308 208-208S370.692 24 256 24zm0 376c-88.366 0-160-71.634-160-160s71.634-160 160-160 160 71.634 160 160-71.634 160-160 160zm64-232H252a12 12 0 0 0-12 12v132a12 12 0 0 0 3.76 8.764l96 72a12 12 0 0 0 16.24-1.53 12 12 0 0 0-1.52-16.24l-88-66V180a12 12 0 0 0-12-12z"></path>
    </svg>
    TIME
  </div>
  <div id="packageTimeLinkDynamic" class="column-dynamic">
    ${userInfo.timeExpire}
  </div>`;

 document.getElementById('filesDownloadedLink').innerHTML = `
  <div id="filesDownloadedLinkStatic" class="column-static">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="-49 141 512 512" width="16" height="16" aria-hidden="true" class="_24ydrq0 _1286nb11sr _1286nb11h9 _1286nb11m _1286nb12q9">
      <path d="M438 403c-13.808 0-25 11.193-25 25v134c0 19.299-15.701 35-35 35H36c-19.299 0-35-15.701-35-35V428c0-13.807-11.193-25-25-25s-25 11.193-25 25v134c0 46.869 38.131 85 85 85h342c46.869 0 85-38.131 85-85V428c0-13.807-11.192-25-25-25"></path>
      <path d="M189.322 530.678a25.004 25.004 0 0 0 35.356 0l84.853-84.853c9.763-9.763 9.763-25.592 0-35.355s-25.592-9.763-35.355 0L232 452.645V172c0-13.807-11.193-25-25-25s-25 11.193-25 25v280.645l-42.175-42.175c-9.764-9.763-25.592-9.763-35.355 0s-9.763 25.592 0 35.355z"></path>
    </svg>
    DOWNLOADS
  </div>
  <div id="filesDownloadedLinkDynamic" class="column-dynamic">
    ${userInfo.downloaded}/${userInfo.limitFile}
  </div>`;

  // Ẩn button Đăng nhập
  document.getElementById('userDropdownLi').style.display = 'none';

  // Hiện dropdown thông tin người dùng
  document.getElementById('userInfoLi').style.display = 'block';
  
    // Lưu thông tin đăng nhập vào localStorage
    localStorage.setItem('loggedInUserID', userInfo.userId);
}

