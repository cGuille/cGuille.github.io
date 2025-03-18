set -eu

SCRIPT_DIR=$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )
ROOT_DIR="$(realpath "${SCRIPT_DIR}/..")"
source "${ROOT_DIR}/bin/logger.bash"

BUILD_DIR="$1"
SOURCE_FILE="$2"

PAGE_PATH="$(realpath --relative-to="${ROOT_DIR}/src/pages" "$SOURCE_FILE")"

log "⋅⋅ Page ${PAGE_PATH}…"

DEST_DIR="${BUILD_DIR}/$(dirname "$PAGE_PATH")"
DEST_NAME="$(basename "$PAGE_PATH" .php)"
DEST_PATH="$(realpath --canonicalize-missing "${DEST_DIR}/${DEST_NAME}")"

mkdir -p "$DEST_DIR"
php "$SOURCE_FILE" > "$DEST_PATH"
