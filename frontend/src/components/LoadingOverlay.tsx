"use client";

import { useLoading } from "../context/LoadingContext";
import { Header } from "./Header";
import Image from "next/image";

export const LoadingOverlay = () => {
  const { isLoading } = useLoading();

  if (!isLoading) return null;

  const slices = [0, 45, 90, 135, 180, 225, 270, 315];

  return (
    <div className="fixed inset-0 z-50 flex flex-col text-green GeneralPurposeBg">
      <Header />
      <div className="flex flex-col items-center justify-center">
        <p className="text-5xl font-bold mb-20">Loading...</p>

        <div className="relative w-[280px] h-[280px] animate-spin-slow flex items-center justify-center rotate-clockwise">
          {slices.map((deg, index) => (
            <div
              key={index}
              className="absolute"
              style={{
                transform: `
                  rotate(${deg}deg)
                  translateY(-82px)
                `,
                transformOrigin: "center center",
              }}
            >
              <Image
                src="/piza.svg"
                alt={`Pizza Slice ${index + 1}`}
                width={140}
                height={140}
                className="w-[140px] h-[140px]"
              />
            </div>
          ))}
        </div>

        <p className="text-3xl font-bold mt-20 text-center">
          サイゼリヤの店名は、創業日である<br />
          2017月7日の誕生花「クチナシ」に由来します。
        </p>
      </div>
    </div>
  );
};
