<div>
    <button @click="$dispatch('logout')"
        onclick="this.disabled = true; this.style.backgroundColor = '#515A5A'; this.style.cursor='wait'; setTimeout(() => this.disabled = false, 5000)"
        class="bg-slate-800 text-white hover:bg-slate-700 hover:text-white w-full py-3 pl-5 duration-500 text-start">
        <i class="fa-solid fa-right-from-bracket mr-3"></i>Logout
    </button>
</div>
