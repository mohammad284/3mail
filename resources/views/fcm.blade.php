<!DOCTYPE html>
<html>
	<head>
		<title>fcm not</title>
		<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
		<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body>
		<h1> fcm notification  </h1>
		<br>
		<center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center>


			<script>
		// Your web app's Firebase configuration
		var firebaseConfig = {
			apiKey: "AIzaSyDyQcjKdCMTqMDMCHylaU20WgZ0eniXpGs",
			authDomain: "mohammadhussen-edea9.firebaseapp.com",
			projectId: "mohammadhussen-edea9",
			storageBucket: "mohammadhussen-edea9.appspot.com",
			messagingSenderId: "111711610488",
			appId: "1:111711610488:web:ff4876aaa5c1ad9df0ef8d"
		};
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);

		const messaging = firebase.messaging();

		function initFirebaseMessagingRegistration() {
			messaging.requestPermission().then(function () {
				return messaging.getToken()
			}).then(function(token) {
				
				axios.post("{{ route('fcmToken') }}",{
					_method:"PATCH",
					token
				}).then(({data})=>{
					console.log(data)
				}).catch(({response:{data}})=>{
					console.error(data)
				})

			}).catch(function (err) {
				console.log(`Token Error :: ${err}`);
			});
		}

		initFirebaseMessagingRegistration();
	
		messaging.onMessage(function({data:{body,title}}){
			new Notification(title, {body});
		});
	</script>

	</body>
</html>