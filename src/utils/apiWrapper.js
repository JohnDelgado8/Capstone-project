export default {
  apiRoot: "http://localhost/Capstone-System/scheduling-system/API",
  login: async function (username, password) {
    let response = await fetch(`${this.apiRoot}/login.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: username,
        password: password,
      }),
    });
    return await response.json();
  },
  register: async function (data) {},
  // add more api call functions here
};
