import 'package:flutter/material.dart';
import 'login_screen.dart';
import 'home_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  Future<bool> checkLogin() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString("token") != null;
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: FutureBuilder(
        future: checkLogin(),
        builder: (context, snapshot) {
          if (!snapshot.hasData) {
            return Scaffold(body: Center(child: CircularProgressIndicator()));
          }
          return snapshot.data == true ? HomeScreen() : LoginScreen();
        },
      ),
    );
  }
}