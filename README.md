# 🧩 DiscordBridge

A full-featured Discord bot integration plugin for PocketMine-MP. It syncs player activity with Discord, supports bot commands, and bridges in-game chat with your server's Discord channel.

![DiscordBridge Banner](https://i.imgur.com/DOt5ziV.png)

---

## 📦 Features

- ✅ Sends player join/leave notifications to Discord
- 📢 Broadcasts in-game messages to Discord
- 🔁 Optional chat bridge: syncs Discord messages to in-game chat
- 🧠 Supports bot commands like `!online` (extendable)
- ⚙️ Built on **DiscordPHP (v10+)**, runs asynchronously

---

## 🚀 Installation

### 1. Requirements

- PHP 8.1 or newer
- PocketMine-MP 5.x
- [Composer](https://getcomposer.org)

### 2. Clone or Download

```bash
git clone https://github.com/xRookieFight/DiscordBridge.git
cd DiscordBridge
```

### 3. Install Composer Dependencies

```bash
composer install
```

> 💡 Note: If you encounter a version error, make sure your ```composer.json``` includes:

```json
"team-reflex/discord-php": "^10.0"
```

## ⚙️ Configuration
After installing, configure the plugin via ```plugin_data/DiscordBridge/config.yml```:
```yaml
discord:
  bot_token: "YOUR_DISCORD_BOT_TOKEN"
  guild_id: "123456789012345678"
  channel_id: "123456789012345678"

messages:
  join: "{player} joined the game."
  quit: "{player} left the game."
  chat: "{player} -> {message}"
```
To get your IDs:

- Enable Developer Mode in Discord → Right-click server/channel → Copy ID
