import { extendTheme, type ThemeConfig } from "@chakra-ui/react";

const config: ThemeConfig = {
  initialColorMode: "dark",
  useSystemColorMode: false,
};

export const dashboardTheme = extendTheme({
  config,
  colors: {
    brand: {
      50: "#cbbff8",
      100: "#876cea",
      200: "#582CFF",
      300: "#542de1",
      400: "#4a25d0",
      500: "#3915bc",
      600: "#300eaa",
      700: "#1c0377",
      800: "#130156",
      900: "#0e0042",
    },
    navy: {
      50: "#d0dcfb",
      100: "#aac0fe",
      200: "#a3b9f8",
      300: "#728fea",
      400: "#3652ba",
      500: "#1b3bbb",
      600: "#24388a",
      700: "#1b254b",
      800: "#111c44",
      900: "#0b1437",
    },
  },
  styles: {
    global: () => ({
      body: {
        bg: "#0f1535",
        color: "white",
        fontFamily: "'Plus Jakarta Display', sans-serif",
        backgroundImage: "url('https://demos.creative-tim.com/vision-ui-dashboard-chakra/static/media/body-background.0ff30a10.png')",
        backgroundSize: "cover",
        backgroundPosition: "center center",
      },
      html: {
        fontFamily: "'Plus Jakarta Display', sans-serif",
      },
    }),
  },
  components: {
    Card: {
      baseStyle: {
        p: "22px",
        display: "flex",
        flexDirection: "column",
        backdropFilter: "blur(120px)",
        width: "100%",
        borderRadius: "20px",
        bg: "linear-gradient(127.09deg, rgba(6, 11, 40, 0.94) 19.41%, rgba(10, 14, 35, 0.49) 76.65%)",
        backgroundClip: "border-box",
        border: "1px solid rgba(226, 232, 240, 0.3)",
      },
    },
    Button: {
      baseStyle: {
        borderRadius: "12px",
      },
      variants: {
        brand: {
          bg: "brand.200",
          color: "white",
          _hover: {
            bg: "brand.300",
          },
        },
      },
    },
  },
});
