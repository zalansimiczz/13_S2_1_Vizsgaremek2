import 'dart:async';
import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:geolocator/geolocator.dart';
import 'login_screen.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {

  Timer? _timer;

  @override
  void initState() {
    super.initState();
    startAutoSending();
  }

  void startAutoSending() {
    _timer = Timer.periodic(Duration(seconds: 10), (timer) {
      sendPosition();
    });
  }

  @override
  void dispose() {
    _timer?.cancel();
    super.dispose();
  }

  Future<Position> _getCurrentLocation() async {
    bool serviceEnabled;
    LocationPermission permission;

    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      throw Exception("Location services are disabled.");
    }

    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        throw Exception("Location permission denied");
      }
    }

    if (permission == LocationPermission.deniedForever) {
      throw Exception("Location permanently denied");
    }

    return await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);
  }

  Future<void> sendPosition() async {
    try {
      print("SENDING POSITION...");

      final prefs = await SharedPreferences.getInstance();
      final token = prefs.getString("token");

      final position = await _getCurrentLocation();

      print("LAT: ${position.latitude}");
      print("LON: ${position.longitude}");

      final response = await http.post(
        Uri.parse("http://192.168.1.192/toll_api/send_position.php"),
        headers: {
          "Content-Type": "application/json",
        },
        body: jsonEncode({
          "token": token,
          "lat": position.latitude,
          "lon": position.longitude
        }),
      );

      print("STATUS: ${response.statusCode}");
      print("BODY: ${response.body}");

    } catch (e) {
      print("ERROR: $e");
    }
  }

  Future<void> logout() async {
    _timer?.cancel();

    final prefs = await SharedPreferences.getInstance();
    await prefs.remove("token");

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(builder: (context) => LoginScreen()),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Tracking"),
        actions: [
          IconButton(
            icon: Icon(Icons.logout),
            onPressed: logout,
          )
        ],
      ),
      body: Center(
        child: Text(
          "Tracking every 10 seconds...",
          style: TextStyle(fontSize: 18),
        ),
      ),
    );
  }
}