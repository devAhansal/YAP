import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = "http://localhost:8000";
//  await axios.post('/logout');
// await axios.post('/login', {
//     email: "salaheddineahansal@gmail.com",
//     password: "password",
// });
// axios.get("api/user");