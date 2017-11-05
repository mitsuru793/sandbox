/*
ログインしたことがあるかをmapで管理する
*/
package main

func main() {
	log := loginUsers{make(map[int]bool)}
	mike := user{1, "Mike"}

	if (log.isLoggingIn(mike)) {
		panic("Mike is not loggin in.")
	}

	if (log.hasLoggedIn(mike)) {
		panic("Mike has not logged in.")
	}

	log.login(mike)

	if (!log.isLoggingIn(mike)) {
		panic("Mike is loggin in.")
	}

	if (!log.hasLoggedIn(mike)) {
		panic("Mike has logged in.")
	}

	log.logout(mike)

	if (log.isLoggingIn(mike)) {
		panic("Mike is not loggin in.")
	}

	if (!log.hasLoggedIn(mike)) {
		panic("Mike has logged in.")
	}
}

type user struct {
	id   int
	name string
}

type loginUsers struct {
	users map[int]bool
}

func (login *loginUsers) login(u user) {
	login.users[u.id] = true
}

func (login *loginUsers) logout(u user) {
	login.users[u.id] = false
}

// ログインしているか
func (login *loginUsers) isLoggingIn(u user) bool {
	if login.users[u.id] == true {
		return true;
	}
	return false;
}

// ログインしたことがあるか
func (login *loginUsers) hasLoggedIn(u user) bool {
	if _, ok := login.users[u.id]; ok {
		return true;
	}
	return false;
}
