// Jexactyl Software. (https://jexactyl.com)
// Green: #189a1c
// Gray: hsl(211, 22%, 21%)

console.log(Jexactyl);

const suspended = Jexactyl.suspended;
const active = Jexactyl.servers.length - Jexactyl.suspended;
const freeDisk = Jexactyl.diskTotal - Jexactyl.diskUsed;
const freeMemory = Jexactyl.memoryTotal - Jexactyl.memoryUsed;

const diskChart = new Chart($("#disk_chart"), {
    type: "pie",
    data: {
        labels: ["空闲硬盘", "已使用硬盘"],
        datasets: [{
            backgroundColor: ["#189a1c", "hsl(211, 22%, 21%)"],
            data: [freeDisk, Jexactyl.diskUsed]
        }]
    }
});

const ramChart = new Chart($("#ram_chart"), {
    type: "pie",
    data: {
        labels: ["空闲内存", "已使用内存"],
        datasets: [{
            backgroundColor: ["#189a1c", "hsl(211, 22%, 21%)"],
            data: [freeMemory, Jexactyl.memoryUsed]
        }]
    }
});

const serversChart = new Chart($("#servers_chart"), {
    type: "pie",
    data: {
        labels: ["正常的服务器", "暂停的服务器"],
        datasets: [{
            backgroundColor: ["#189a1c", "hsl(211, 22%, 21%)"],
            data: [active, suspended]
        }]
    }
});
