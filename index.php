<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sederhana - Vue.js Offline</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div id="app" class="container">
    <div class="login-card">
      <h2>Login Aplikasi</h2>

      <div class="form-group">
        <label>Username</label>
        <input type="text" v-model="username" placeholder="Masukkan username">
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" v-model="password" placeholder="Masukkan password">
      </div>

      <div class="checkbox">
        <input type="checkbox" v-model="checkbox" @change="statuscb">
        <label>Remember Me</label>
      </div>

      <button @click="login">Login</button>

      <button @click="forgot">Forget Password</button>

      <p class="message" :class="{'error': error, 'success': success}">
        {{ message }}
      </p>

      <p class="pesan">
        {{ pesan }}
      </p>
    </div>
  </div>

  <!-- Import Vue.js Offline -->
  <script src="./vuejs/vue.global.js"></script>

  <script>
    const { createApp } = Vue;

    createApp({
      data() {
        return {
          username: '',
          password: '',
          message: '',
          checkbox: false,
          pesan: '',
          error: false,
          success: false
        }
      },
      methods: {
        login() {
          this.error = false;
          this.success = false;

          fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: this.username,
                password: this.password
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
                this.message = data.message;
                this.success = true;
            } else {
                this.message = data.message;
                this.error = true;
            }
          })
          .catch(error => {
            console.error('Error:', error);
            this.message = "Terjadi kesalahan koneksi";
            this.error = true;
          });

        },
        statuscb() {
            if (this.checkbox == true) {
                this.pesan = "Remember Me Aktif";
            } else {
                this.pesan = "";
            }
        }, 
        forgot() {
            alert("Hubungi Kami Untuk Memulihkan Akun.");
        }
      }
    }).mount('#app');
  </script>
</body>
</html>
